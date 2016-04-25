<style type="text/css">


/*
 * Base structure
 */

/* Move down content because we have a fixed navbar that is 50px tall */
body {
  padding-top: 50px;
}


/*
 * Global add-ons
 */

.sub-header {
  padding-bottom: 10px;
  border-bottom: 1px solid #eee;
}

/*
 * Top navigation
 * Hide default border to remove 1px line.
 */
.navbar-fixed-top {
  border: 0;
}

/*
 * Sidebar
 */

/* Hide for mobile, show later */
.sidebar {
  display: none;
}

.sidebar-toggle {
    display: none !important;
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
}
/*
@media (max-width: 767px) {
    .sidebar-toggle {
        display: none;
    }
}*/

@media (min-width: 768px) {
    .sidebar {
        position: fixed;
        top: 51px;
        bottom: 0;
        left: 0;
        z-index: 1000;
        display: block;
        padding: 20px;
        overflow-x: hidden;
        overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
        background-color: #f5f5f5;
        border-right: 1px solid #eee;
        -webkit-transition: all 0.5s ease;
        -moz-transition: all 0.5s ease;
        -o-transition: all 0.5s ease;
        transition: all 0.5s ease;
    }
}

/* Sidebar navigation */
.nav-sidebar {
    margin-right: -21px; /* 20px padding + 1px border */
    margin-bottom: 20px;
    margin-left: -20px;
}
.nav-sidebar > li > a {
    padding-right: 20px;
    padding-left: 20px;
}
.nav-sidebar > .active > a,
.nav-sidebar > .active > a:hover,
.nav-sidebar > .active > a:focus {
    color: #fff;
    background-color: #428bca;
}

/*
 * Main content
 */

.main {
    padding: 20px;
}
@media (min-width: 768px) {
    .main {
        padding-right: 40px;
        padding-left: 40px;
    }
}
.main .page-header {
    margin-top: 0;
}


/*
 * Placeholder dashboard ideas
 */

.placeholders {
    margin-bottom: 30px;
    text-align: center;
}
.placeholders h4 {
    margin-bottom: 0;
}
.placeholder {
    margin-bottom: 20px;
}
.placeholder img {
    display: inline-block;
    border-radius: 50%;
}


#spacepublic {
    height: 100%;
}

.spacePublic {
    padding: 6px 8px;
    font: 14px/16px Arial, Helvetica, sans-serif;
    background: white;
    background: rgba(255,255,255,0.8);
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
    border-radius: 5px;
}

#map_streetview, #pano_streetview {
    float: left;
    height: 50%;
    width: 100%;
}

#menu_tootle_nav {
    font-size: 14px;
}

</style>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Exp/No exp navegación</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Sig EP</a>
            <a class="navbar-brand" id="menu_tootle_nav" href="#">Cerrar/Abrir Panel Izquierdo</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Perfil</a></li>
                <li><a href="#">Ayuda</a></li>
            </ul>
            <form class="navbar-form navbar-right">
                <input class="form-control" placeholder="Search..." type="text">
            </form>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <div id="wrapper_sidebar" class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li class="active" id="menu_tootle"><a href="#">Cerrar Panel <span class="sr-only">(current)</span></a></li>
                <li><a href="#">Overview </a></li>
                <li><a href="#">Reports</a></li>
                <li><a href="#">Analytics</a></li>
                <li><a href="#">Export</a></li>
            </ul>
            <ul class="nav nav-sidebar">
                <?php echo Modules::run('complain/Complain/get_list', $quejas); ?>
            </ul>
        </div>
        <div class="col-sm-9 col-md-10" id='spacepublic'></div>
        <div class="col-sm-3 col-md-2" id='streetview'>
            <div id="map_streetview"></div>
            <div id="pano_streetview"></div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $("#menu_tootle").click(function(e){
            e.preventDefault(); toggleSidebarLeft(e);
        });

        $("#menu_tootle_nav").click(function(e){  
            e.preventDefault(); toggleSidebarLeft(e); 
        });

        var toggleSidebarLeft = function(e){
            $("#wrapper_sidebar").toggleClass("sidebar-toggle");
        };
    });
</script>