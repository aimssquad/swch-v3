const intervals = [
  { label: "year", seconds: 31536000 },
  { label: "month", seconds: 2592000 },
  { label: "day", seconds: 86400 },
  { label: "hour", seconds: 3600 },
  { label: "minute", seconds: 60 },
  { label: "second", seconds: 1 },
];

function timeSince(date) {
  const seconds = Math.floor((Date.now() - date.getTime()) / 1000);
  const interval = intervals.find((i) => i.seconds < seconds);
  const count = Math.floor(seconds / interval.seconds);
  return `${count} ${interval.label}${count !== 1 ? "s" : ""} ago`;
}

$(document).ready(() => {
  $("form#frm_project_create").validate({
    rules: {
      title: {
        required: true,
      },
    },
    messages: {
      title: {
        required: "Please enter title",
      },
    },
    submitHandler: function (form) {
      form.submit();
      //   console.log("ok");
      //   $.ajax({
      //       url: base_url + "/projects/add",
      //       method: "POST",
      //       // headers: {
      //       //     "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      //       // },
      //       data: $(form).serialize(),
      //       success: (data) => {
      //           console.log("success", data);
      //           alert("Project has been created successfully");
      //       },
      //       error: (error) => {
      //           console.log(error);
      //           alert(JSON.stringify(error));
      //       },
      //   });
    },
  });

  $("form#frm_project_update").validate({
    rules: {
      title: {
        required: true,
      },
    },
    messages: {
      title: {
        required: "Please enter title",
      },
    },
    submitHandler: function (form) {
      form.submit();
      //   console.log("ok");
      //   $.ajax({
      //       url: base_url + "/projects/add",
      //       method: "POST",
      //       // headers: {
      //       //     "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      //       // },
      //       data: $(form).serialize(),
      //       success: (data) => {
      //           console.log("success", data);
      //           alert("Project has been created successfully");
      //       },
      //       error: (error) => {
      //           console.log(error);
      //           alert(JSON.stringify(error));
      //       },
      //   });
    },
  });

  // const getEmployeeList = ()=>{
  //     $.ajax({
  //         url :
  //         meth
  //     })
  // }
});
$(function () {
  departmentChangeEvent();
});
function departmentChangeEvent() {
  $("#department").on("change", () => {
    getEmployeesByDepertment($("#department").val());
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
    op += `<option value="${d?.id}" >${
      d?.emp_fname +
      (d?.mname ? " " + d?.mname : "") +
      (d?.lname ? " " + d?.lname : "")
    }</option>`;
  });
  $("#employee").html(op);
}
$(document).on("hide.bs.modal", ".create_task_modal", function () {
  window.location.reload();
  //Do stuff here
});
