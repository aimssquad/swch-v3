$(function () {
  $("#doj").datepicker();
  $("#app_period_start_date").datepicker({
    minDate: new Date(),
  });
  $("#app_period_end_date").datepicker({
    minDate: new Date(),
  });
  appPeriodStartDateChangeEvent();
  departmentChangeEvent();
  employeeSelectionEvent();
  if ($("#department").val()) getEmployeesByDepertment($("#department").val());
  formRequestSubmitEvent();
  filterAdd();
});
function appPeriodStartDateChangeEvent() {
  $("#app_period_start_date").on("change", () => {
    console.log($("#app_period_start_date").val());
    $("#app_period_end_date").datepicker(
      "option",
      "minDate",
      new Date($("#app_period_start_date").val())
    );
  });
}
function filterAdd() {
  console.log("filterAdd");
  $("#filter_option").on("change", () => {
    console.log($("#filter_option").val());
    if ($("#filter_option").val() != "")
      window.location.href =
        base_url + "/performances?status=" + $("#filter_option").val();
    else {
      window.location.href = base_url + "/performances";
    }
  });
}

function departmentChangeEvent() {
  $("#department").on("change", () => {
    //alert('okk');
    getEmployeesByDepertment($("#department").val());
    setEmployeeDetailsInForm(null);
  });
}
function getEmployeesByDepertment(dep) {
  console.log("dept>>", dep);
  if (typeof dep !== "undefined") {
    $.ajax({
      url: base_url + "/getEmployeeByDept",
      method: "POST",
      data: {
        dept: dep,
        _token: $('meta[name="csrf-token"]').attr("content"),
      },
      success: (data) => {
        console.log(data);
        if (data.status) {
          setEmployeeList(data?.data?.employees);
        }
      },
      error: (err) => {
        console.log(err);
      },
    });
  }
}
function setEmployeeList(data) {
  var op = `<option value="">Select Employee</option>`;
  data?.map((d) => {
    op += `<option value="${d?.emp_code}" >${
      d?.emp_fname +
      (d?.mname ? " " + d?.mname : "") +
      (d?.lname ? " " + d?.lname : "")
    }</option>`;
  });
  $("#employee").html(op);
}
function employeeSelectionEvent() {
  $("#employee").on("change", () => {
    getEmployeeDetails($("#employee").val());
  });
}
function getEmployeeDetails(id) {
  $.ajax({
    url: base_url + "/getEmployeeDetails",
    method: "POST",
    data: {
      id: id,
      _token: $('meta[name="csrf-token"]').attr("content"),
    },
    success: (data) => {
      console.log(data);
      if (data.status) {
        setEmployeeDetailsInForm(data?.data?.employee);
      }
    },
    error: (err) => {
      console.log(err);
    },
  });
}
function setEmployeeDetailsInForm(data) {
  if (data) {
    $("#job_title").val(data?.emp_designation);
    $("#doj").val(moment(new Date(data?.emp_doj)).format("DD/MM/YYYY"));
    $("#rep_auth").val(
      data?.rep_fname +
        (data?.rep_mname ? " " + data?.rep_mname : "") +
        (data?.rep_lname ? " " + data?.rep_lname : "")
    );
    $("#rep_auth_id").val(data?.rep_emp_code);
    // $("#job_title").val(data?.emp_designation);
  } else {
    $("#job_title").val("");
    $("#doj").val("");
    $("#rep_auth").val("");
    $("#rep_auth_id").val("");
  }
}
function formRequestSubmitEvent() {
  $("form#frm_performance_request").validate({
    rules: {
      rep_auth: {
        required: true,
      },
      apprisal_period_end: {
        required: true,
      },
      apprisal_period_start: {
        required: true,
      },
      emp_code: {
        required: true,
      },
    },
    messages: {
      rep_auth: {
        required: "Reporting authority is required",
      },
      apprisal_period_end: {
        required: "Apprisal period start date is required",
      },
      apprisal_period_start: {
        required: "Apprisal period end date is required",
      },
      emp_code: {
        required: "Employee is required",
      },
    },
    submitHandler: function (form) {
      form.submit();
    },
  });
  $("form#frm_performance_edit_request").validate({
    rules: {
      rep_auth: {
        required: true,
      },
      apprisal_period_end: {
        required: true,
      },
      apprisal_period_start: {
        required: true,
      },
      emp_code: {
        required: true,
      },
      rating: {
        required: true,
      },
      performance_comments: {
        required: true,
      },
    },
    messages: {
      rep_auth: {
        required: "Reporting authority is required",
      },
      apprisal_period_end: {
        required: "Apprisal period start date is required",
      },
      apprisal_period_start: {
        required: "Apprisal period end date is required",
      },
      emp_code: {
        required: "Employee is required",
      },
      rating: {
        required: "Rating is required",
      },
      performance_comments: {
        required: "Comment is required",
      },
    },
    submitHandler: function (form) {
      form.submit();
    },
  });
}
function setRatingOptions() {
  var str = `<option value="">Select rating</option>`;
  for (let i = 1; i <= 5; i++) {
    str += `<option value="${i}">${i}</option>`;
  }
  console.log("str>>", str);
  $("#per_rating").html(str);
}
// function setAutocompleteEmployeeData(data) {
//   console.log("employees>>", data);
//   $("#employee").autocomplete({
//     minLength: 2,
//     source: function (request, response) {
//       response(
//         $.map(data, function (obj, key) {
//           return {
//             label:
//               obj?.emp_fname +
//               (obj?.emp_mname ? " " + obj?.emp_mname : "") +
//               " " +
//               obj?.emp_lname, // Label for Display
//             value: obj.id, // Value
//           };
//           // var name = obj.name.toUpperCase();

//           // if (name.indexOf(request.term.toUpperCase()) != -1) {
//           //   return {
//           //     label: obj.emp_fname + " " + obj.emp_mname + " " + obj.emp_lname, // Label for Display
//           //     value: obj.id, // Value
//           //   };
//           // } else {
//           //   return null;
//           // }
//         })
//       );
//     },
//     focus: function (event, ui) {
//       event.preventDefault();
//     },
//     // Once a value in the drop down list is selected, do the following:
//     select: function (event, ui) {
//       event.preventDefault();
//       // place the person.given_name value into the textfield called 'select_origin'...
//       $("#employee").val(ui.item.label);
//       // ... any other tasks (like setting Hidden Fields) go here...
//     },
//   });
// }
