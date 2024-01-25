<?php include_once("inc/header.nav.php"); ?>
    <div role="main" class="main">
        <section class="page-header page-header-modern bg-color-light-scale-1 page-header-lg">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 align-self-center p-static order-2 text-center">
                        <h1 class="font-weight-bold text-dark">Sign In</h1>
                    </div>
                    <div class="col-md-12 align-self-center order-1">
                        <ul class="breadcrumb d-block text-center">
                            <li><a href="./">Home</a></li>
                            <li class="active">Sign in</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <h2 class="font-weight-bold text-5 mb-0">Login</h2>
                    <form id="login-account" name="login-account">
                        <div id="response-alert"></div>
                        <div class="row">
                            <div class="form-group col">
                                <label class="form-label text-color-dark text-3">Email address <span class="text-color-danger">*</span></label>
                                <input type="email" class="form-control form-control-lg text-4" name="email"  required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label class="form-label text-color-dark text-3">Password <span class="text-color-danger">*</span></label>
                                <input type="password" class="form-control form-control-lg text-4" name="password"  required>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="form-group col-md-auto">
                                <a class="text-decoration-none text-color-dark text-color-hover-primary font-weight-semibold text-2" href="#">Forgot Password?</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <input type="submit" value="Login" class="btn btn-dark btn-modern w-100 text-uppercase rounded-0 font-weight-bold text-3 py-3" data-loading-text="Please wait..." />
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="form-group col-md-auto">
<!--                                Don't have an account ? <a class="text-decoration-none text-color-dark text-color-hover-primary font-weight-semibold text-2" href="register">Sign Up Now</a>-->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php include_once("inc/footer.nav.php"); ?>