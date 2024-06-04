<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>INSPINIA | E-commerce</title>

    <link href="../css/bootstrap.min.css" rel="stylesheet" />
    <link href="../font-awesome/css/font-awesome.css" rel="stylesheet" />

    <!-- FooTable -->
    <link href="../css/plugins/footable/footable.core.css" rel="stylesheet" />

    <link href="../css/animate.css" rel="stylesheet" />
    <link href="../css/style.css" rel="stylesheet" />
  </head>

  <body>
    
    <div id="wrapper">
     
<?php include("../includes/menu.php"); ?>
      <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
          <nav
            class="navbar navbar-static-top"
            role="navigation"
            style="margin-bottom: 0"
          >
        <div class="row wrapper border-bottom white-bg page-heading">
          <div class="col-lg-10">
            <h2>E-commerce product list</h2>
            <ol class="breadcrumb">
              <li>
                <a href="index.html">Home</a>
              </li>
              <li>
                <a>E-commerce</a>
              </li>
              <li class="active">
                <strong>Product list</strong>
              </li>
            </ol>
          </div>
          <div class="col-lg-2"></div>
        </div>

        <div class="wrapper wrapper-content animated fadeInRight ecommerce">
          <div class="ibox-content m-b-sm border-bottom">
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label class="control-label" for="product_name"
                    >Product Name</label
                  >
                  <input
                    type="text"
                    id="product_name"
                    name="product_name"
                    value=""
                    placeholder="Product Name"
                    class="form-control"
                  />
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label class="control-label" for="price">Price</label>
                  <input
                    type="text"
                    id="price"
                    name="price"
                    value=""
                    placeholder="Price"
                    class="form-control"
                  />
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label class="control-label" for="quantity">Quantity</label>
                  <input
                    type="text"
                    id="quantity"
                    name="quantity"
                    value=""
                    placeholder="Quantity"
                    class="form-control"
                  />
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label class="control-label" for="status">Status</label>
                  <select name="status" id="status" class="form-control">
                    <option value="1" selected>Enabled</option>
                    <option value="0">Disabled</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="ibox">
                <div class="ibox-content">
                  <table
                    class="footable table table-stripped toggle-arrow-tiny"
                    data-page-size="15"
                  >
                    <thead>
                      <tr>
                        <th data-toggle="true">Product Name</th>
                        <th data-hide="phone">Model</th>
                        <th data-hide="all">Description</th>
                        <th data-hide="phone">Price</th>
                        <th data-hide="phone,tablet">Quantity</th>
                        <th data-hide="phone">Status</th>
                        <th class="text-right" data-sort-ignore="true">
                          Action
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Example product 1</td>
                        <td>Model 1</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$50.00</td>
                        <td>1000</td>
                        <td>
                          <span class="label label-primary">Enable</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 2</td>
                        <td>Model 2</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$40.00</td>
                        <td>4300</td>
                        <td>
                          <span class="label label-primary">Enable</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 3</td>
                        <td>Model 3</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$22.00</td>
                        <td>300</td>
                        <td>
                          <span class="label label-danger">Disabled</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 4</td>
                        <td>Model 4</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$67.00</td>
                        <td>2300</td>
                        <td>
                          <span class="label label-primary">Enable</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 5</td>
                        <td>Model 5</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$76.00</td>
                        <td>800</td>
                        <td>
                          <span class="label label-warning">Low stock</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 6</td>
                        <td>Model 6</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$60.00</td>
                        <td>6000</td>
                        <td>
                          <span class="label label-danger">Disabled</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 7</td>
                        <td>Model 7</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$32.00</td>
                        <td>700</td>
                        <td>
                          <span class="label label-danger">Disabled</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 8</td>
                        <td>Model 8</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$86.00</td>
                        <td>5180</td>
                        <td>
                          <span class="label label-primary">Enable</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 9</td>
                        <td>Model 9</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$97.00</td>
                        <td>450</td>
                        <td>
                          <span class="label label-primary">Enable</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 10</td>
                        <td>Model 10</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$43.00</td>
                        <td>7600</td>
                        <td>
                          <span class="label label-primary">Enable</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 1</td>
                        <td>Model 1</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$50.00</td>
                        <td>1000</td>
                        <td>
                          <span class="label label-primary">Enable</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 2</td>
                        <td>Model 2</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$40.00</td>
                        <td>4300</td>
                        <td>
                          <span class="label label-primary">Enable</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 3</td>
                        <td>Model 3</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$22.00</td>
                        <td>300</td>
                        <td>
                          <span class="label label-warning">Low stock</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 4</td>
                        <td>Model 4</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$67.00</td>
                        <td>2300</td>
                        <td>
                          <span class="label label-primary">Enable</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 5</td>
                        <td>Model 5</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$76.00</td>
                        <td>800</td>
                        <td>
                          <span class="label label-primary">Enable</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 6</td>
                        <td>Model 6</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$60.00</td>
                        <td>6000</td>
                        <td>
                          <span class="label label-primary">Enable</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 7</td>
                        <td>Model 7</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$32.00</td>
                        <td>700</td>
                        <td>
                          <span class="label label-primary">Enable</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 8</td>
                        <td>Model 8</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$86.00</td>
                        <td>5180</td>
                        <td>
                          <span class="label label-primary">Enable</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 9</td>
                        <td>Model 9</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$97.00</td>
                        <td>450</td>
                        <td>
                          <span class="label label-primary">Enable</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 10</td>
                        <td>Model 10</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$43.00</td>
                        <td>7600</td>
                        <td>
                          <span class="label label-primary">Enable</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="6">
                          <ul class="pagination pull-right"></ul>
                        </td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="footer">
          <div class="pull-right">10GB of <strong>250GB</strong> Free.</div>
          <div><strong>Copyright</strong>  Telistema &copy; 2024</div>
        </div>
      </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- FooTable -->
    <script src="js/plugins/footable/footable.all.min.js"></script>

    <!-- Page-Level Scripts -->
    <script>
      $(document).ready(function () {
        $(".footable").footable();
      });
    </script>
  </body>
</html>


      <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
          <nav
            class="navbar navbar-static-top"
            role="navigation"
            style="margin-bottom: 0"
          >
            <div class="navbar-header">
              <a
                class="navbar-minimalize minimalize-styl-2 btn btn-success"
                href="#"
                ><i class="fa fa-bars"></i>
              </a>
              <form
                role="search"
                class="navbar-form-custom"
                action="search_results.html"
              >
                <div class="form-group">
                  <input
                    type="text"
                    placeholder="Search for something..."
                    class="form-control"
                    name="top-search"
                    id="top-search"
                  />
                </div>
              </form>
            </div>
            <ul class="nav navbar-top-links navbar-right">
              <li>
                <span class="m-r-sm text-muted welcome-message"
                  >Welcome to INSPINIA+ Admin Theme.</span
                >
              </li>
              <li class="dropdown">
                <a
                  class="dropdown-toggle count-info"
                  data-toggle="dropdown"
                  href="#"
                >
                  <i class="fa fa-envelope"></i>
                  <span class="label label-warning">16</span>
                </a>
                <ul class="dropdown-menu dropdown-messages">
                  <li>
                    <div class="dropdown-messages-box">
                      <a href="profile.html" class="pull-left">
                        <img alt="image" class="img-circle" src="../img/a7.jpg" />
                      </a>
                      <div class="media-body">
                        <small class="pull-right">46h ago</small>
                        <strong>Mike Loreipsum</strong> started following
                        <strong>Monica Smith</strong>. <br />
                        <small class="text-muted"
                          >3 days ago at 7:58 pm - 10.06.2014</small
                        >
                      </div>
                    </div>
                  </li><div id="page-wrapper" class="gray-bg">
                    <div class="row border-bottom">
                      <nav
                        class="navbar navbar-static-top"
                        role="navigation"
                        style="margin-bottom: 0"
                      >
                        <div class="navbar-header">
                          <a
                            class="navbar-minimalize minimalize-styl-2 btn btn-success"
                            href="#"
                            ><i class="fa fa-bars"></i>
                          </a>
                          <form
                            role="search"
                            class="navbar-form-custom"
                            action="search_results.html"
                          >
                            <div class="form-group">
                              <input
                                type="text"
                                placeholder="Search for something..."
                                class="form-control"
                                name="top-search"
                                id="top-search"
                              />
                            </div>
                          </form>
                        </div>
                        <ul class="nav navbar-top-links navbar-right">
                          <li>
                            <span class="m-r-sm text-muted welcome-message"
                              >Welcome to INSPINIA+ Admin Theme.</span
                            >
                          </li>
                          <li class="dropdown">
                            <a
                              class="dropdown-toggle count-info"
                              data-toggle="dropdown"
                      <a href="profile.html" class="pull-left">
                        <img alt="image" class="img-circle" src="../img/a4.jpg" />
                      </a>
                      <div class="media-body">
                        <small class="pull-right text-navy">5h ago</small>
                        <strong>Chris Johnatan Overtunk</strong> started
                        following <strong>Monica Smith</strong>. <br />
                        <small class="text-muted"
                          >Yesterday 1:21 pm - 11.06.2014</small
                        >
                      </div>
                    </div>
                  </li>
                  <li class="divider"></li>
                  <li>
                    <div class="dropdown-messages-box">
                      <a href="profile.html" class="pull-left">
                        <img
                          alt="image"
                          class="img-circle"
                          src="../img/profile.jpg"
                        />
                      </a>
                      <div class="media-body">
                        <small class="pull-right">23h ago</small>
                        <strong>Monica Smith</strong> love
                        <strong>Kim Smith</strong>. <br />
                        <small class="text-muted"
                          >2 days ago at 2:30 am - 11.06.2014</small
                        >
                      </div>
                    </div>
                  </li>
                  <li class="divider"></li>
                  <li>
                    <div class="text-center link-block">
                      <a href="mailbox.html">
                        <i class="fa fa-envelope"></i>
                        <strong>Read All Messages</strong>
                      </a>
                    </div>
                  </li>
                </ul>
              </li>
              <li class="dropdown">
                <a
                  class="dropdown-toggle count-info"
                  data-toggle="dropdown"
                  href="#"
                >
                  <i class="fa fa-bell"></i>
                  <span class="label label-primary">8</span>
                </a>
                <ul class="dropdown-menu dropdown-alerts">
                  <li>
                    <a href="mailbox.html">
                      <div>
                        <i class="fa fa-envelope fa-fw"></i> You have 16
                        messages
                        <span class="pull-right text-muted small"
                          >4 minutes ago</span
                        >
                      </div>
                    </a>
                  </li>
                  <li class="divider"></li>
                  <li>
                    <a href="profile.html">
                      <div>
                        <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                        <span class="pull-right text-muted small"
                          >12 minutes ago</span
                        >
                      </div>
                    </a>
                  </li>
                  <li class="divider"></li>
                  <li>
                    <a href="grid_options.html">
                      <div>
                        <i class="fa fa-upload fa-fw"></i> Server Rebooted
                        <span class="pull-right text-muted small"
                          >4 minutes ago</span
                        >
                      </div>
                    </a>
                  </li>
                  <li class="divider"></li>
                  <li>
                    <div class="text-center link-block">
                      <a href="notifications.html">
                        <strong>See All Alerts</strong>
                        <i class="fa fa-angle-right"></i>
                      </a>
                    </div>
                  </li>
                </ul>
              </li>

              <li>
                <a href="login.html">
                  <i class="fa fa-sign-out"></i> Cerrar Sección
                </a>
              </li>
            </ul>
          </nav>
        </div>
        <div class="row wrapper border-bottom white-bg page-heading">
          <div class="col-lg-10">
            <h2>E-commerce product list</h2>
            <ol class="breadcrumb">
              <li>
                <a href="index.html">Home</a>
              </li>
              <li>
                <a>E-commerce</a>
              </li>
              <li class="active">
                <strong>Product list</strong>
              </li>
            </ol>
          </div>
          <div class="col-lg-2"></div>
        </div>

        <div class="wrapper wrapper-content animated fadeInRight ecommerce">
          <div class="ibox-content m-b-sm border-bottom">
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label class="control-label" for="product_name"
                    >Product Name</label
                  >
                  <input
                    type="text"
                    id="product_name"
                    name="product_name"
                    value=""
                    placeholder="Product Name"
                    class="form-control"
                  />
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label class="control-label" for="price">Price</label>
                  <input
                    type="text"
                    id="price"
                    name="price"
                    value=""
                    placeholder="Price"
                    class="form-control"
                  />
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label class="control-label" for="quantity">Quantity</label>
                  <input
                    type="text"
                    id="quantity"
                    name="quantity"
                    value=""
                    placeholder="Quantity"
                    class="form-control"
                  />
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label class="control-label" for="status">Status</label>
                  <select name="status" id="status" class="form-control">
                    <option value="1" selected>Enabled</option>
                    <option value="0">Disabled</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="ibox">
                <div class="ibox-content">
                  <table
                    class="footable table table-stripped toggle-arrow-tiny"
                    data-page-size="15"
                  >
                    <thead>
                      <tr>
                        <th data-toggle="true">Product Name</th>
                        <th data-hide="phone">Model</th>
                        <th data-hide="all">Description</th>
                        <th data-hide="phone">Price</th>
                        <th data-hide="phone,tablet">Quantity</th>
                        <th data-hide="phone">Status</th>
                        <th class="text-right" data-sort-ignore="true">
                          Action
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Example product 1</td>
                        <td>Model 1</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$50.00</td>
                        <td>1000</td>
                        <td>
                          <span class="label label-primary">Enable</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 2</td>
                        <td>Model 2</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$40.00</td>
                        <td>4300</td>
                        <td>
                          <span class="label label-primary">Enable</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 3</td>
                        <td>Model 3</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$22.00</td>
                        <td>300</td>
                        <td>
                          <span class="label label-danger">Disabled</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 4</td>
                        <td>Model 4</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$67.00</td>
                        <td>2300</td>
                        <td>
                          <span class="label label-primary">Enable</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 5</td>
                        <td>Model 5</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$76.00</td>
                        <td>800</td>
                        <td>
                          <span class="label label-warning">Low stock</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 6</td>
                        <td>Model 6</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$60.00</td>
                        <td>6000</td>
                        <td>
                          <span class="label label-danger">Disabled</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 7</td>
                        <td>Model 7</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$32.00</td>
                        <td>700</td>
                        <td>
                          <span class="label label-danger">Disabled</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 8</td>
                        <td>Model 8</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$86.00</td>
                        <td>5180</td>
                        <td>
                          <span class="label label-primary">Enable</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 9</td>
                        <td>Model 9</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$97.00</td>
                        <td>450</td>
                        <td>
                          <span class="label label-primary">Enable</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 10</td>
                        <td>Model 10</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$43.00</td>
                        <td>7600</td>
                        <td>
                          <span class="label label-primary">Enable</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 1</td>
                        <td>Model 1</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$50.00</td>
                        <td>1000</td>
                        <td>
                          <span class="label label-primary">Enable</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 2</td>
                        <td>Model 2</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$40.00</td>
                        <td>4300</td>
                        <td>
                          <span class="label label-primary">Enable</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 3</td>
                        <td>Model 3</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$22.00</td>
                        <td>300</td>
                        <td>
                          <span class="label label-warning">Low stock</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 4</td>
                        <td>Model 4</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$67.00</td>
                        <td>2300</td>
                        <td>
                          <span class="label label-primary">Enable</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 5</td>
                        <td>Model 5</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$76.00</td>
                        <td>800</td>
                        <td>
                          <span class="label label-primary">Enable</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 6</td>
                        <td>Model 6</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$60.00</td>
                        <td>6000</td>
                        <td>
                          <span class="label label-primary">Enable</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 7</td>
                        <td>Model 7</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$32.00</td>
                        <td>700</td>
                        <td>
                          <span class="label label-primary">Enable</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 8</td>
                        <td>Model 8</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$86.00</td>
                        <td>5180</td>
                        <td>
                          <span class="label label-primary">Enable</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 9</td>
                        <td>Model 9</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$97.00</td>
                        <td>450</td>
                        <td>
                          <span class="label label-primary">Enable</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Example product 10</td>
                        <td>Model 10</td>
                        <td>
                          It is a long established fact that a reader will be
                          distracted by the readable content of a page when
                          looking at its layout. The point of using Lorem Ipsum
                          is that it has a more-or-less normal distribution of
                          letters, as opposed to using 'Content here, content
                          here', making it look like readable English.
                        </td>
                        <td>$43.00</td>
                        <td>7600</td>
                        <td>
                          <span class="label label-primary">Enable</span>
                        </td>
                        <td class="text-right">
                          <div class="btn-group">
                            <button class="btn-white btn btn-xs">View</button>
                            <button class="btn-white btn btn-xs">Edit</button>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="6">
                          <ul class="pagination pull-right"></ul>
                        </td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="footer">
          <div class="pull-right">10GB of <strong>250GB</strong> Free.</div>
          <div><strong>Copyright</strong>  Telistema &copy; 2024</div>
        </div>
      </div>
    </>

    <!-- Mainly scripts -->
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="../js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="../js/inspinia.js"></script>
    <script src="../js/plugins/pace/pace.min.js"></script>

    <!-- FooTable -->
    <script src="../js/plugins/footable/footable.all.min.js"></script>

    <!-- Page-Level Scripts -->
    <script>
      $(document).ready(function () {
        $(".footable").footable();
      });
    </script>
  </body>
</html>
