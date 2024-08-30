

<footer class="footer">
    <div class="container-fluid d-flex justify-content-between">
      <div class="copyright">
        2024, © Copyright
      </div>
      <div>
        Developed by
        <a target="_blank" href="https://globemw.net">globemw.net</a>.
      </div>
    </div>
  </footer>
</div>

<!-- Custom template | don't include it in your project! -->
<div class="custom-template">
  <div class="title">Settings</div>
  <div class="custom-content">
    <div class="switcher">
      <div class="switch-block">
        <h4>Logo Header</h4>
        <div class="btnSwitch">
          <button
            type="button"
            class="selected changeLogoHeaderColor"
            data-color="dark"
          ></button>
          <button
            type="button"
            class="changeLogoHeaderColor"
            data-color="blue"
          ></button>
          <button
            type="button"
            class="changeLogoHeaderColor"
            data-color="purple"
          ></button>
          <button
            type="button"
            class="changeLogoHeaderColor"
            data-color="light-blue"
          ></button>
          <button
            type="button"
            class="changeLogoHeaderColor"
            data-color="green"
          ></button>
          <button
            type="button"
            class="changeLogoHeaderColor"
            data-color="orange"
          ></button>
          <button
            type="button"
            class="changeLogoHeaderColor"
            data-color="red"
          ></button>
          <button
            type="button"
            class="changeLogoHeaderColor"
            data-color="white"
          ></button>
          <br />
          <button
            type="button"
            class="changeLogoHeaderColor"
            data-color="dark2"
          ></button>
          <button
            type="button"
            class="changeLogoHeaderColor"
            data-color="blue2"
          ></button>
          <button
            type="button"
            class="changeLogoHeaderColor"
            data-color="purple2"
          ></button>
          <button
            type="button"
            class="changeLogoHeaderColor"
            data-color="light-blue2"
          ></button>
          <button
            type="button"
            class="changeLogoHeaderColor"
            data-color="green2"
          ></button>
          <button
            type="button"
            class="changeLogoHeaderColor"
            data-color="orange2"
          ></button>
          <button
            type="button"
            class="changeLogoHeaderColor"
            data-color="red2"
          ></button>
        </div>
      </div>
      <div class="switch-block">
        <h4>Navbar Header</h4>
        <div class="btnSwitch">
          <button
            type="button"
            class="changeTopBarColor"
            data-color="dark"
          ></button>
          <button
            type="button"
            class="changeTopBarColor"
            data-color="blue"
          ></button>
          <button
            type="button"
            class="changeTopBarColor"
            data-color="purple"
          ></button>
          <button
            type="button"
            class="changeTopBarColor"
            data-color="light-blue"
          ></button>
          <button
            type="button"
            class="changeTopBarColor"
            data-color="green"
          ></button>
          <button
            type="button"
            class="changeTopBarColor"
            data-color="orange"
          ></button>
          <button
            type="button"
            class="changeTopBarColor"
            data-color="red"
          ></button>
          <button
            type="button"
            class="selected changeTopBarColor"
            data-color="white"
          ></button>
          <br />
          <button
            type="button"
            class="changeTopBarColor"
            data-color="dark2"
          ></button>
          <button
            type="button"
            class="changeTopBarColor"
            data-color="blue2"
          ></button>
          <button
            type="button"
            class="changeTopBarColor"
            data-color="purple2"
          ></button>
          <button
            type="button"
            class="changeTopBarColor"
            data-color="light-blue2"
          ></button>
          <button
            type="button"
            class="changeTopBarColor"
            data-color="green2"
          ></button>
          <button
            type="button"
            class="changeTopBarColor"
            data-color="orange2"
          ></button>
          <button
            type="button"
            class="changeTopBarColor"
            data-color="red2"
          ></button>
        </div>
      </div>
      <div class="switch-block">
        <h4>Sidebar</h4>
        <div class="btnSwitch">
          <button
            type="button"
            class="changeSideBarColor"
            data-color="white"
          ></button>
          <button
            type="button"
            class="selected changeSideBarColor"
            data-color="dark"
          ></button>
          <button
            type="button"
            class="changeSideBarColor"
            data-color="dark2"
          ></button>
        </div>
      </div>
    </div>
  </div>
  <div class="custom-toggle">
    <i class="icon-settings"></i>
  </div>
</div>
<!-- End Custom template -->
</div>

<!-- Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="logoutModalLabel">Logout</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure to logout now...!!!
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal">Close</button>
          <a href="{{ route('admin.logout') }}" class="btn btn-danger text-white btn-sm">Logout</a>
        </div>
      </div>
    </div>
</div>


<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
         <form action="#" method="POST" id="deleteRecordForm">
            <input type="hidden" name="delete_record_form" id="delete_record_form">
            <input type="hidden" name="delete_record_id" id="delete_record_id">
            <input type="hidden" name="delete_record_type" id="delete_record_type">

            <div class="modal-header">
                <h5 class="modal-title deleteModelTopic" id="deleteModalLabel">Delete Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body deleteModelDesctiption">
            Are you sure to Delete this Record now...!!!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger text-white btn-sm deleteModelBtn">Delete</button>
            </div>
          </form>
      </div>
    </div>
</div>
