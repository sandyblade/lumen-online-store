<template>
    <main class="flex-shrink-0 p-3 border-bottom bg-gray text-uppercase mb-5" id="breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mt-2">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Page Not Found</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </main>
    <main class="flex-shrink-0 p-3 mb-5">
        <div class="d-flex align-items-center justify-content-center">
            <div class="text-center">
                <h1 class="display fw-bold text-muted text-error-code">404</h1>
                <p class="fs-3"> <span class="text-danger">Opps!</span> Page Not Found</p>
                <div class="lead">
                    Sorry, the page you're looking for doesn't exist. If you think something is broken, report a problem.
                </div>
                <router-link to="/" class="btn btn-primary w-25 mt-3">
                    <i class="bi-house me-2"></i>Back To Home
                </router-link>
            </div>
        </div>
    </main>
</template>