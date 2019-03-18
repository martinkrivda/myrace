    <!-- Generate Start Times -->
<div class="modal fade" id="generate-starttime" tabindex="-1" role="dialog" aria-labelledby="startTimeModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="startTimeModalLabel">{{trans('title.generateStartTime')}}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5><strong>{{trans('title.countOfVacants')}}</strong></h5>
        <sup>{{trans('title.eachCategory')}}</sup>
        <div id ="vacants">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" id="generate-submit" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
