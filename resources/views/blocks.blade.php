<!DOCTYPE html>
<html>

<head>
  <link data-require="bootstrap-css@3.1.1" data-semver="3.1.1" rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" />
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <div>
          <h1>Blocks</h1>
          <br>

          <!-- Trigger the modal with a button -->
          <button id="newBlockBtn" type="button" class="btn btn-info" data-toggle="modal" data-target="#newModal">New Block</button>
          <br><br>

          <div id="block_details" style="display: none;">
            <a href="#" class="block-show" data-block>test</a>
          </div>

          <div id="block_actions" style="display: none;">
            <a href="#" class="block-edit" data-block>Edit</a> |
            <a href="#" class="block-delete" data-block>Delete</a>
          </div>

          <table class="blocks table table-bordered table-responsive">
            <thead>
              <tr>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>


        </div>

        <div class="col-lg-8">
          <small>click on block to see details</small>
        </div>

        <ul class="pagination"></ul>

      </div>
    </div>
  </div>

  <div id="blockFields" style="display: none;">
    <div class="form-group">
      <label for="title">Title:</label>
      <input type="text" name="title" class="block-title form-control" id="title" required="required"/>
    </div>
    <div class="form-group">
      <label for="body">Body:</label>
      <textarea name="body" class="block-body form-control" id="body" required="required"></textarea>
    </div>
  </div>

  <!-- New Modal -->
  <div class="modal fade" id="newModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <form id="newBlockForm">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">New block</h4>
          </div>
          <div class="modal-body">
          </div>
          <div class="modal-footer">
            <button type="submit" class="save btn btn-primary">Save</button>
        </form>
        </div>
      </div>
      
    </div>
  </div>

  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <form id="editBlockForm">
          <input type="hidden" name="_method" value="put"/>
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit block</h4>
          </div>
          <div class="modal-body">
          </div>
          <div class="modal-footer">
            <button type="submit" class="save btn btn-primary">Save</button>
        </form>
        </div>
      </div>
      
    </div>
  </div>

  <!-- Show Modal -->
  <div class="modal fade" id="showModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Show block</h4>
        </div>
        <div class="modal-body">
          <article class="block-body"></article>
          <div class="block-imgs"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

  <script data-require="jquery@*" data-semver="2.0.3" src="//code.jquery.com/jquery-2.0.3.min.js"></script>
  <script data-require="bootstrap@3.1.1" data-semver="3.1.1" src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="{{ asset('js/blocks.js') }}"></script>
  
  <script type="text/javascript">get_blocks(1);</script>

  <script type="text/javascript">
    $('#editModal').on('hidden.bs.modal', function () {
        // do something…
        // alert();
    })
  </script>
</body>

</html>
