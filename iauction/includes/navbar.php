  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
  
<div style="padding:2em;">
    <h1>iAuction</h1>
	<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="./home.php"><span class="glyphicon glyphicon-bullhorn" aria-hidden="true"></span></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav nav-pills">
        <li class="active"><a href="./home.php">Home<span class="sr-only">(current)</span></a></li>		<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Create<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="./createAuction.php">Auction</a></li>
            <li><a href="./createItem.php">Item</a></li>
            <li><a href="./createUser.php">User</a></li>           
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Maintain<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="./maintainAuction.php">Auction</a></li>
            <li><a href="./maintainItem.php">Item</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">User</a></li>
            <li><a href="#">System</a></li>
          </ul>
        </li>
      </ul>
      <form class="navbar-form navbar-left" action="search.php" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="support.php">Support</a></li>
		<li><a href="includes/logout.php">Log off</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</div>