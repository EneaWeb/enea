<ul class="feeds">
    @foreach ($logs as $log)
        <li>
            <div class="col1">
                <div class="cont">
                    <div class="cont-col1">
                        <div class="label label-success">
                            <i class="fa fa-check"></i> 
                        </div>
                            
                    </div>
                    <div class="cont-col2">
                        <div class="desc"> 
                            &nbsp;&nbsp; {!!\App\Log::renderContent($log)!!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col2">
                <div class="date"> .. </div>
            </div>
        </li>
    @endforeach
</ul>