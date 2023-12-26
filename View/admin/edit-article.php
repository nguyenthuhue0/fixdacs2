<?php
    include_once __DIR__ . '/../../Model/database.php';
    include_once __DIR__ . '/../../Model/article.php';
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    //article approved: 0 chưa duyệt
    //article approved: 1 đã duyệt
    //article approved: 2 ẩn
    //show 0 default(approved =1 =2)
    //show 1 unapproved(approved = 0)
    //show 2 hidden (approved =2)
    //show 3 
    $db = database::getDB();
    $article = new Article($db);
    if (isset($_GET['id']) && isset($_GET['approveArc'])) {
        if ($_GET['approveArc'] == 1) {
            $article->setAtr($_GET['id'], 1); 
        }
        else{
            $article->setAtr($_GET['id'], 0); 
        }
    }
    if (isset($_GET['id']) && isset($_GET['showArc'])) {
        if ($_GET['showArc'] == 1) {
            $article->setAtr($_GET['id'], 1); 
        }
        else{
            $article->setAtr($_GET['id'], 2); 
        }
    }
    if(isset($_GET['show'])){
        switch ($_GET['show']){
            case 0:
                $allArticle = $article->loadAllArticleAd();
                break;
            case 1:
                $allArticle = $article->loadAllArticleUnapproved();
                break;
            case 2:
                $allArticle = $article->loadAllArticleHidden();
                break;
        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>PTE Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="./index.php">PTE ADMIN</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <!-- <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..."
                    aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i
                        class="fas fa-search"></i></button>
            </div> -->
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="../profile-details.php">Profile details</a></li>
                    <li><a class="dropdown-item" href="../change-password.php">Change password</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="../../Controller/login-action/logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="./index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Home
                        </a>
                        <div class="sb-sidenav-menu-heading">Management</div>

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages"
                            aria-expanded="false" aria-controls="collapsePages">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Management
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePages" aria-labelledby="headingTwo"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#pagesCollapseArticle" aria-expanded="false"
                                    aria-controls="pagesCollapseAuth">
                                    Manage articles
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseArticle" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a id="goToAddArticle" href="./article-upload-form.php" class="nav-link">Add
                                            article</a>
                                        <a id="goToEditArticle" href="./edit-article.php?show=0" class="nav-link">Edit
                                            article</a>
                                    </nav>
                                </div>
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#pagesCollapseAcc" aria-expanded="false"
                                    aria-controls="pagesCollapseAuth">
                                    Manage accounts
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseAcc" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="./edit-user.php">All Account</a>
                                    </nav>
                                </div>
                                <!-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        Error
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="401.html">401 Page</a>
                                            <a class="nav-link" href="404.html">404 Page</a>
                                            <a class="nav-link" href="500.html">500 Page</a>
                                        </nav>
                                    </div> -->
                            </nav>
                        </div>
                        <!-- <div class="sb-sidenav-menu-heading">Addons</div>
                            <a class="nav-link" href="charts.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Charts
                            </a>
                            <a class="nav-link" href="tables.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tables
                            </a> -->
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?php echo $_SESSION['username']?>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Article ID</th>
                                <th scope="col">Title</th>
                                <th scope="col">Content</th>
                                <th scope="col">Date Posted</th>
                                <?php if($_GET['show'] == 1):?>
                                    <th scope="col">Approval</th>
                                    <th scope="col">Edit article</th>
                                    <th scope="col">Delete article</th>
                                <?php else:?>
                                    <th scope="col">Toggle Approval</th>
                                    <th scope="col">Edit article</th>
                                    <th scope="col">Delete article</th>
                                <?php endif;?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($allArticle as $article): ?>
                            <tr>
                                <td><?php echo $article['articleId'];?></td>
                                <td><?php echo $article['title']; ?></td>
                                <td><?php echo nl2br(htmlspecialchars($article['content'])); ?></td>
                                <td><?php echo $article['datePosted']; ?></td>
                                <?php if($_GET['show'] == 1):?>
                                    <td><a id="approveArc" type="button" class="btn btn-outline-success " onclick="toggleApproval(<?php echo $article['articleId']?>, 1)">Approve</a></td>
                                <?php else:?>
                                    <!-- show arc 2: hien -->
                                    <?php if ($article['approved'] === 2): ?>
                                    <td><a id="showArc" type="button" class="btn btn-outline-success  "
                                            onclick="toggleApproval(<?php echo $article['articleId']?>, 1)">Show</a></td>
                                    <?php else:?>
                                    <td><a id="hideArc" type="button" class="btn btn-outline-secondary"
                                            onclick="toggleApproval(<?php echo $article['articleId']?>, 2)">Hide</td>
                                    <?php endif;?>
                                <?php endif;?>
                                <td><a id="" href="./article-upload-form.php?id=<?php echo $article['articleId']?>"
                                        type="button" class="btn btn-outline-primary">Edit</a></td>
                                <td><a id=""
                                        href="../../Controller/article-action/delete-article.php?id=<?php echo $article['articleId']?>"
                                        type="button" class="btn btn-outline-danger">Delete</a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>
    function toggleApproval(articleId, approvalStatus) {
        $.ajax({
            type: "GET",
            url: "./edit-article.php",
            data: {
                id: articleId,
                showArc: approvalStatus
            },
            success: function(response) {
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Ajax request failed. Status:', status, 'Error:', error);
            }
        });
    }
    </script>
</body>

</html>