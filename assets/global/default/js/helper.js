/** *************** COMMON HELPER FUNCTIONS *************** */
/** *************** SUCCESS ALERT *************** */
function jqSuccessAlert(content, theme = "modern") {
  $.alert({
    icon: "fa fa-check",
    title: "Awesome",
    content,
    type: "green",
    theme: theme,
    backgroundDismiss: true,
    buttons: [
      {
        text: "Continue",
        btnClass: "btn-green",
      },
    ],
  });
}
/** *************** ERROR ALERT *************** */
function jqErrorAlert(content, theme = "modern") {
  $.alert({
    icon: "fa fa-times",
    title: "Opps!",
    content,
    type: "red",
    theme: theme,
    backgroundDismiss: true,
    buttons: [
      {
        text: "Try Again",
        btnClass: "btn-red",
      },
    ],
  });
}
/** *************** WARNING ALERT *************** */
function jqWarningAlert(content, theme = "modern") {
  $.alert({
    icon: "fa fa-warning",
    title: "Caution",
    content,
    type: "orange",
    theme: theme,
    backgroundDismiss: true,
    buttons: [
      {
        text: "Okay",
        btnClass: "btn-orange",
      },
    ],
  });
}
/** *************** CONFIRM DIALOG *************** */
function jqConfirm(confirmed, content = "", title = "", theme = "") {
  if (content == "") {
    content = "Please Confirm Before Continue...";
  }
  if (title == "") {
    title = "Confirm!";
  }
  if (theme == "") {
    theme = "modern";
  }
  $.confirm({
    title,
    content,
    theme,
    buttons: {
      Confirm: {
        btnClass: "btn-danger",
        action: function () {
          confirmed();
        },
      },
      Cancel: {
        btnClass: "btn-success",
      },
    },
  });
}
/** *************** FULLSCREEN AJAX LOADER *************** */
function showLoader(text = "", backgroundDismiss = false) {
  $("body").loadingModal({ text, backgroundDismiss });
}
/** *************** HIDE CURRENT SHOWING LOADER *************** */
function hideLoader() {
  $("body").loadingModal("destroy");
}
/** *************** GENERATE RANDOM NUMBER *************** */
function random(start = 1, end = 10000) {
  return Math.floor(Math.random() * end + start);
}
/** *************** FORM VALIDATION AND SUBMIT *************** */
/**
 * validate form and then submit if no error found
 * @param {*} formId string | form id selector e.g #demo-form
 * @param {*} submitSuccess success callback function
 * @param {*} submitError error call back unction
 */
function validate_form(formId, submitSuccess, submitError) {
  $(
    formId +
      " input," +
      formId +
      " select," +
      formId +
      " textarea," +
      formId +
      " checkbox"
  ).jqBootstrapValidation({
    preventSubmit: true,
    // submitError: function ($form, event, errors) { },
    submitError,
    // submitSuccess: function ($form, event){}
    submitSuccess,
    filter: function () {
      return $(this).is(":visible");
    },
  });
}
/** *************** CHECK ALL CHECKBOX IN GIVEN REFERENCE *************** */
function checkAll(ref) {
  $(ref)
    .find('input[type="checkbox"]')
    .each(function () {
      $(this).prop("checked", true);
    });
}
/** *************** UNCHECKED ALL CHECKBOX IN GIVEN REFERENCE *************** */
function uncheckedAll(ref) {
  $(ref)
    .find('input[type="checkbox"]')
    .each(function () {
      $(this).prop("checked", false);
    });
}
/** *************** MAKE SLUG USEFUL FOR URL *************** */
function makeSlug(str) {
  return str
    .trim()
    .toLowerCase()
    .replace(/[0-9]/g, "")
    .replace(/[^\w ]+/g, "")
    .replace(/ +/g, "-")
    .replace(/-\s*$/, "");
}

/** *************** AJAX HELPER FUNCTIONS *************** */
/**
 *
 * @param {*} action string | rows, row, insert, insertOrUpdate, update, delete
 * @param {*} ajax_path string | table, table/column/value
 * @param {*} data object | data to be inserted or updated
 * @param {*} success success callback function
 * @param {*} error error callback function
 */
function callAjax(action, ajax_path, data, success) {
  var flag = true;
  switch (action) {
    case "rows":
      ajax_path = "getRows/" + ajax_path;
      type = "GET";
      break;
    case "row":
      ajax_path = "getRow/" + ajax_path;
      type = "GET";
      break;
    case "insert":
      ajax_path = "insertRow/" + ajax_path;
      type = "POST";
      break;
    case "update":
      ajax_path = "updateRow/" + ajax_path;
      type = "POST";
      break;
    case "insertOrUpdate":
      ajax_path = "insertOrUpdate/" + ajax_path;
      type = "POST";
      break;
    case "delete":
      flag = false;
      ajax_path = "deleteRow/" + ajax_path;
      type = "GET";
      confirm(() => {
        showLoader();
        $.ajax({
          url: baseurl + "ajax/" + ajax_path,
          type,
          data,
          cache: false,
          success,
          error: function (error) {
            console.log(error.responseText);
            jqErrorAlert("unable to Communicate to server");
          },
          complete: function () {
            hideLoader();
          },
        });
      });
      break;
  }
  if (flag) {
    showLoader();
    $.ajax({
      url: baseurl + "ajax/" + ajax_path,
      type,
      data,
      cache: false,
      success,
      error: function (error) {
        console.log(error.responseText);
        jqErrorAlert("unable to Communicate to server");
      },
      complete: function () {
        hideLoader();
      },
    });
  }
}
/** *************** DELETE ROW FROM TABLE VIEW AND DATABASE ALSO *************** */
function del_row(table_key_value, target, $this) {
  callAjax("delete", table_key_value, {}, function (res) {
    hideLoader();
    if (res.success) {
      jqSuccessAlert(target + " Removed Successfully");
      $this.closest("tr").remove();
    } else {
      jqErrorAlert("Unable To Remove " + target);
    }
  });
}
/** *************** UPDATE SELECT VALUE ********************* */
function update_select(table_key_value, column, true_condition, $this) {
  let data = {};
  data[column] = $this.value;
  showLoader();
  callAjax("update", table_key_value, data, function (res) {
    hideLoader();
    if (res.success) {
      jqSuccessAlert("Data Updated Successfully");
      if ($this.value == true_condition) {
        $($this).removeClass("bg-danger");
        $($this).addClass("bg-success");
      } else {
        $($this).removeClass("bg-success");
        $($this).addClass("bg-danger");
      }
    } else {
      jqErrorAlert("Unable To Update Data");
    }
  });
}
