<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="twitter-bootstrap/less/bootstrap.less" rel="stylesheet/less">
        <script src="less-1.3.0.min.js"></script>
        
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>
        <script src="http://code.jquery.com/ui/1.8.24/jquery-ui.min.js" type="text/javascript"></script>
        
        <script src="jquery.livequery.js"></script>
        
        <script src="general.js"></script>
        
    </head>
    <body>
        <div class="container">
            <div class="navbar">
                <div class="navbar-inner">
                    <a class="brand" href="#">Scrum4free</a>
                    <ul class="nav">
                        <li class="active"><a href="#">Scrum</a></li>
                    </ul>
                </div>
            </div>
            <div class="row tasks">
                <div class="span4 column">
                    <div class="taskState">Wait</div>
                    <div class="task">
                        <div class="title"><span class="taskId">1.</span>Title 1</div>
                        <div class="description">Description</div>
                        <div class="actors">Actors, actors</div>
                        <div class="actions"><a href="#" class="delete">Delete</a></div>
                    </div>
                    <div class="task">
                        <div class="title"><span class="taskId">1.</span>Title 1</div>
                        <div class="description">Description</div>
                        <div class="actors">Actors, actors</div>
                        <div class="actions"><a href="#" class="delete">Delete</a></div>
                    </div>
                    <input type="button" class="addTask" value="Add a task">
                </div>
                <div class="span4 column">
                    <div class="taskState">In progress</div>
                </div>
                <div class="span4 column">
                    <div class="taskState">Done</div>
                </div>
            </div>
        </div>
    </body>
</html>