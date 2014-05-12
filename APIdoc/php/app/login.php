<?php $title = 'Login'; $checkSession = false; include("header.php"); ?>
    <br><br><br>
    <div class="panel panel-default col-md-offset-2 col-md-8">
        <div class="panel-heading">Console Login</div>
        <div class="panel-body">
            <form novalidate class="form-horizontal" action="/controllers/user_login.php" method="POST">
                <div class="form-group">
                    <input type="text" class="form-control" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                </div>
                <div class="form-group">
                    <label class="checkbox">
                        <input type="checkbox"><span>Remember me</span>
                    </label>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block">Sign In</button>
                </div>
            </form>
        </div>
    </div>

<?php include("footer.php"); ?>