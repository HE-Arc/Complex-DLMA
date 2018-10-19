<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="<?php echo url(""); ?>">{{config('app.name', '<Complex-DLMA>')}}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo url(""); ?>">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo url("create_dlma"); ?>">Create new DLMA</a>
            </li>
        </ul>

        <a class="btn btn-outline-primary mr-3" href="<?php echo url("login"); ?>">Login</a>
        <a class="btn btn-outline-secondary" href="<?php echo url("registration"); ?>">Registration</a>
    </div>
</nav>