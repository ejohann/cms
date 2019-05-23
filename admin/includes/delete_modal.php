<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete Post Dialog</h4>
      </div>
      <div class="modal-body">
        <h6>Are you sure you want to delete this post?</h6>
      </div> 
      <div class="modal-footer">
         <form style="position: absolute; margin-left: 425px" action="" method="post">
          <input type="hidden" class="modal_delete_link" name="delete_item" value=""></input>
          <input class="btn btn-danger delete_link" type="submit" name="delete" value="Delete"></input>
          
          </form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>

  </div>
</div>