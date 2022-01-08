<div class="container-fluid" id="centre">
    <div class="row">        
            <?= $controllerData["detailProduit"] ?>     
            <div class="col-sm">
            <div class="card" style="max-height: 600px; width: 500px;">
            <h5 class="card-header"> Commentaire et note </h5> 
                <div class="card-body" style="overflow-y: scroll">
                
                
                <?= $controllerData["reviews"] ?>
                
                
                </div> 
                <div class="card-footer">
                <div class="form-outline w-100">
                <textarea
                  class="form-control"
                  id="textAreaExample"
                  rows="1" style="background: #fff;"></textarea>
               
              </div>
              <div class="float-end mt-2 pt-1">
              <button type="button" class="btn btn-primary btn-sm">Post comment</button>
              <button type="button" class="btn btn-outline-primary btn-sm">Cancel</button>
            </div>
                </div>   
            </div>

        </div>  
         
    </div>
</div>
