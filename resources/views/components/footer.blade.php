

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

<!-- Confirm Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
         <form action="#" method="POST" id="confirmRecordForm">
            <input type="hidden" name="confirm_record_form" id="confirm_record_form">
            <input type="hidden" name="confirm_record_id" id="confirm_record_id">
            <input type="hidden" name="confirm_record_type" id="confirm_record_type">

            <div class="modal-header">
                <h5 class="modal-title confirmModalTopic" id="confirmModalLabel">Confirm Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body confirmModalDesctiption">
            Are you sure to Confirm this Record now...!!!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal">No</button>
                <button type="submit" class="btn btn-danger text-white btn-sm confirmModalBtn">Yes</button>
            </div>
          </form>
      </div>
    </div>
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


<div id="customerProfileModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h3 ng-hide="newUser">CUSTOMER PROFILE</h3>
              <button type="button" class="close" data-bs-dismiss="modal">×</button>
          </div>

          <div class="modal-body">
              <input type="hidden" name="customer_id" id="customer_id">

              <ul class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="pills-tabInvoices-tab" data-bs-toggle="pill" data-bs-target="#pills-tabInvoices" type="button" role="tab" aria-controls="pills-tabInvoices" aria-selected="true">Invoices</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-tabRecurring-tab" data-bs-toggle="pill" data-bs-target="#pills-tabRecurring" type="button" role="tab" aria-controls="pills-tabRecurring" aria-selected="false">Recurring Invoices</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-tabPayments-tab" data-bs-toggle="pill" data-bs-target="#pills-tabPayments" type="button" role="tab" aria-controls="pills-tabPayments" aria-selected="false">Payments</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-tabCredits-tab" data-bs-toggle="pill" data-bs-target="#pills-tabCredits" type="button" role="tab" aria-controls="pills-tabCredits" aria-selected="false">Credit</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-tabCommunications-tab" data-bs-toggle="pill" data-bs-target="#pills-tabCommunications" type="button" role="tab" aria-controls="pills-tabCommunications" aria-selected="false">Communications</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-tabAttachments-tab" data-bs-toggle="pill" data-bs-target="#pills-tabAttachments" type="button" role="tab" aria-controls="pills-tabAttachments" aria-selected="false">Attachments</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-tabApprovals-tab" data-bs-toggle="pill" data-bs-target="#pills-tabApprovals" type="button" role="tab" aria-controls="pills-tabApprovals" aria-selected="false">Approvals</button>
                </li>
              </ul>
              <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="pills-tabInvoices" role="tabpanel" aria-labelledby="pills-tabInvoices-tab">
                    <div id="div_tabInvoices">Loading Invoices</div>
                </div>
                <div class="tab-pane fade" id="pills-tabRecurring" role="tabpanel" aria-labelledby="pills-tabRecurring-tab">
                    <div id="div_tabRecurring">Loading Recurring Invoices</div>
                </div>
                <div class="tab-pane fade" id="pills-tabPayments" role="tabpanel" aria-labelledby="pills-tabPayments-tab">
                    <div id="div_tabPayments">Loading Payments</div>
                </div>
                <div class="tab-pane fade" id="pills-tabCredits" role="tabpanel" aria-labelledby="pills-tabCredits-tab">
                    <div id="div_tabCredits">Loading Credit Notes</div>
                </div>
                <div class="tab-pane fade" id="pills-tabCommunications" role="tabpanel" aria-labelledby="pills-tabCommunications-tab">
                    <div id="div_tabCommunications">Loading Communications</div>
                </div>
                <div class="tab-pane fade" id="pills-tabAttachments" role="tabpanel" aria-labelledby="pills-tabAttachments-tab">
                    <div id="tabAttachments">Loading Attachments</div>
                </div>
                <div class="tab-pane fade" id="pills-tabApprovals" role="tabpanel" aria-labelledby="pills-tabApprovals-tab">
                    <div id="tabApprovals">Loading Approvals</div>
                </div>
              </div>
          </div>
      </div>
   </div>
  </div>


<div id="viewStatementModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">VIEW CUSTOMER ACTIVITY</h4>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span> Close</button>
        </div>
        <div class="modal-body">

        </div>
      </div>
    </div>
  </div>

  <div id="customerStatementModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">VIEW CUSTOMER STATEMENT</h4>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-primary" id="btn_statementemail" data-email="" data-cus-id="" aria-label="Email">Email</button>
                </div>
                <div class="col-md-8">
                  <div class="form-group">
                      <label class="control-label col-md-4" for="statement_type">Statement Type</label>
                          <select class="form-control " id="statement_type" name="statement_type">
                              <option value="due">Due Reminders</option>
                              <option value="all">All Reminders</option>
                              <option value="daterange">Date Range</option>
                          </select>
                  </div>
              </div>
              <div class="col-md-4">
                <span class="text">You can select statement type to show due reminders only or all reminders including future reminders.</span>
              </div>
          </div>
          <div class="row d-none" id="div_daterange">
              <div class="col-md-4">
                  <div class="form-group">
                      <label for="from_date">From Date</label>
                      <input type="date" name="from_date" id="from_date" class="form-control" value="">
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group">
                      <label for="to_date">To Date</label>
                      <input type="date" name="to_date" id="to_date" class="form-control" value="">
                  </div>
              </div>
              <div class="col-md-4 align-self-end pb-4">
                  <button type="button" class="btn btn-success btn-sm" id="btn_generateStatement">Generate Statement</button>
              </div>
          </div>
          <div>
              <div id="div_customerstatement">
                <object type="application/pdf" id="obj_statement_pdf" data="" width="100%" height="500" style="height: auto;">No Support</object>
            </div>
          </div>


        </div>
      </div>
    </div>
  </div>

  <div id="customerStatementEmailModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">EMAIL CUSTOMER STATEMENT</h4>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span> Close</button>
        </div>
        <form id="frm_emailstatement">
        <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label class="control-label" for="email_subject">Subject</label>
                          <input type="text" class="form-control" id="email_subject" name="email_subject" placeholder="Email subject" required />
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label" for="to_email">To address</label>
                          <input type="text" class="form-control" id="to_email" name="to_email" placeholder="To Email address" required />
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label" for="cc_email">CC address</label>
                          <input type="text" class="form-control" id="cc_email" name="cc_email" placeholder="CC Email list" />
                      </div>
                  </div>
                  <div class="col-md-12">
                      <div class="form-group">
                          <label class="control-label" for="email_body">Message</label>
                          <textarea class="form-control" name="email_body" id="email_body"></textarea>
                      </div>
                  </div>
              </div>
              <input type="hidden" id="format_id" name="format_id" />
              <input type="hidden" id="format_type" name="format_type" />
              <input type="hidden" name="file_name" id="file_name">
              <input type="hidden" name="customer_id" id="customer_id">
            </div>
            <div class="modal-footer d-block">
                <div class="row">
                    <div class="col-md-6 pl-0">
                        <div class="form-group">
                            <button type="button" class="btn btn-default form-control" data-bs-dismiss="modal">Cancel</button>

                        </div>
                    </div>
                    <div class="col-md-6 pr-0">
                        <div class="form-group">
                            <button type="submit" id="btn_sendStatement" name="submit" class="btn btn-primary form-control">SEND</button>
                        </div>
                    </div>
                </div>
            </div>
         </form>
      </div>
    </div>
  </div>
