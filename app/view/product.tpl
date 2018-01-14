<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex">

    <title>Product or company header - Bootsnipp.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <link href="/src/style/main.css" rel="stylesheet" id="bootstrap-css">
    <link href="/src/style/items.css" rel="stylesheet" id="bootstrap-css">

</head>
<body>
<div class="container">
    <nav class="navbar">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">PICHKU</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav" hidden>
                    <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
                    <li><a href="#">Link</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-haspopup="true" aria-expanded="false">Dropdown <span
                                    class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">One more separated link</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="navbar-form navbar-left" hidden>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
                <ul class="nav navbar-nav navbar-right">
                    {if $user->isValid()}
                        <li><a href="?family_id=">New</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true" aria-expanded="false">Dropdown <span
                                        class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                            </ul>
                        </li>
                    {else}
                        <li><a href="/shopping/edit_product?family_id={$product->family_id}&product_id={$product->id}">Login</a></li>
                    {/if}
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</div>
{if isset($product)}
    <div class="container">
        <div class="card">
            <div class="container-fliud">
                <div class="wrapper row">
                    <div class="preview col-md-6">

                        <div class="preview-pic tab-content">
                            <div class="tab-pane active" id="pic-1"><img src="{$product->image}"/></div>
                            <div class="tab-pane" id="pic-2"><img src="http://placekitten.com/400/252"/></div>
                        </div>
                        <ul class="preview-thumbnail nav nav-tabs hide">
                            <li class="active"><a data-target="#pic-1" data-toggle="tab"><img
                                            src="http://placekitten.com/200/126"/></a></li>
                            <li><a data-target="#pic-2" data-toggle="tab"><img
                                            src="http://placekitten.com/200/126"/></a>
                            </li>
                        </ul>

                    </div>
                    <div class="details col-md-6">
                        <h3 class="product-title">{$product->title}</h3>
                        <div class="rating">
                            <div class="stars">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                            </div>
                            <span class="review-no">41 reviews</span>
                        </div>
                        <p class="product-description">{$product->description}</p>
                        <h4 class="price">current price:&nbsp;
                            <small>{$product->currency}</small>
                            &nbsp;<span>{$product->price}</span></h4>
                        <p class="vote"><strong>91%</strong> of buyers enjoyed this product! <strong>(87 votes)</strong>
                        </p>
                        <h5 class="sizes" hidden>sizes:
                            <span class="size" data-toggle="tooltip" title="small">s</span>
                            <span class="size" data-toggle="tooltip" title="medium">m</span>
                            <span class="size" data-toggle="tooltip" title="large">l</span>
                            <span class="size" data-toggle="tooltip" title="xtra large">xl</span>
                        </h5>
                        <h5 class="colors" hidden>colors:
                            <span class="color orange not-available" data-toggle="tooltip" title="Not In store"></span>
                            <span class="color green"></span>
                            <span class="color blue"></span>
                        </h5>
                        <div class="action">
                            <a href="{$product->url}" target="_blank" class="add-to-cart btn btn-default" type="button">
                                Buy Product</a>
                            <button class="like btn btn-default" type="button"><span class="fa fa-heart"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{/if}


<div class="clearfix" style="height: 30px"></div>

<div class="container">
    <div class="row">
        {foreach $products as $product}
            <div class="col-sm-3">
                <article class="col-item">
                    <div class="photo">
                        <div class="options-cart-round">
                            <a class="btn btn-default" title="View Details"
                               href="/shopping/product/{$product->family_id}/{$product->id}/info.html"
                            >
                                <span class="fa fa-shopping-cart"></span>
                            </a>
                        </div>
                        <a href="/shopping/product/{$product->family_id}/{$product->id}/info.html"
                        > <img
                                    src="{$product->image}" class="img-responsive product_image_thumb"
                                    alt="Product Image"/> </a>
                    </div>
                    <div class="info">
                        <div class="row">
                            <div class="price-details col-md-6">
                                <p class="details">
                                    {$product->title}
                                </p>
                                <h1></h1>
                                <span class="price-new">{$product->price} {$product->currency}</span>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        {/foreach}
    </div>
</div>
<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
</body>
</html>
