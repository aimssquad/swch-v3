<!DOCTYPE html>
<html>
<head>
  <style>
    .tab, .tab2, .tab3, .tab4, .tab5, .tab6, .tab7 {
      display: none;
    }
    .active {
      display: block;
    }
    .btn {
      margin: 10px;
      padding: 10px;
      background-color: #007BFF;
      color: white;
      border: none;
      cursor: pointer;
    }
    .btn:disabled {
      background-color: #dcdcdc;
      cursor: not-allowed;
    }
  </style>
</head>
<body>
<form action="/your-submit-endpoint" method="POST" onsubmit="return handleSubmit(event)">
  <div class="tab active">
    <input type="text" name="field1"/>
  </div>
  <div class="tab2">
    <input type="text" name="field2"/>
  </div>
  <div class="tab3">
    <input type="text" name="field3"/>
  </div>
  <div class="tab4">
    <input type="text" name="field4"/>
  </div>
  <div class="tab5">
    <input type="text" name="field5"/>
  </div>
  <div class="tab6">
    <input type="text" name="field6"/>
  </div>
  <div class="tab7">
    <input type="text" name="field7"/>
  </div>
  <button class="btn" id="prevBtn" type="button" onclick="showTab(-1)" disabled>Previous</button>
  <button class="btn" id="nextBtn" type="button" onclick="showTab(1)">Next</button>
  <button class="btn" id="submitBtn" type="submit" style="display: none;">Submit</button>
</form>

<script>
  let currentTab = 0;

  function showTab(n) {
    const tabs = document.querySelectorAll('.tab, .tab2, .tab3, .tab4, .tab5, .tab6, .tab7');
    tabs[currentTab].classList.remove('active');
    currentTab = currentTab + n;

    if (currentTab < 0) {
      currentTab = 0;
    }
    if (currentTab >= tabs.length) {
      currentTab = tabs.length - 1;
    }

    tabs[currentTab].classList.add('active');
    
    document.getElementById("prevBtn").disabled = currentTab === 0;
    document.getElementById("nextBtn").style.display = currentTab === tabs.length - 1 ? 'none' : 'inline';
    document.getElementById("submitBtn").style.display = currentTab === tabs.length - 1 ? 'inline' : 'none';
  }

  // function handleSubmit(event) {
  //   event.preventDefault(); // Prevent the default form submission

  //   // Here you can add custom validation or other processing logic

  //   // If everything is valid, you can manually submit the form
  //   // e.g., using AJAX or just:
  //   // event.target.submit();

  //   alert('Form submitted!');
  //   // For demo purposes, just alert. Remove this line in production.
  // }
</script>

</body>
</html>
