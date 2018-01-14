<div class="container">
    <form class="input-group" id="add-form" method="post">
        <input type="text" class="form-control add-url" placeholder="Product URL"
               aria-describedby="basic-addon2"
               onkeyup="document.getElementById('source-url').value = btoa((this.value).replace('http:',''));">
        <span class="input-group-addon" id="basic-addon2">
                <button type="submit" class="btn btn-primary">Add</button>
            </span>
        <input name="page_id" type="hidden" class="add-page_id" value="{$page->id}">
        <input name="urld" type="hidden" class="add-urld" id="source-url">
    </form>
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
    <div class="-row masonboxwrap">
        {foreach $page->sharedSourceList as $product}
            <div class="-col-sm-3 masonbox">
                <article class="col-item">
                    <div class="photo">
                        <div class="options-cart-round">
                            <a class="btn btn-default" title="View Details"
                               href="/product/{$page->id}/{$product->id}/info.html"
                            >
                                <span class="fa fa-shopping-cart"></span>
                            </a>
                        </div>
                        <a href="/product/{$page->id}/{$product->id}/info.html"
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
