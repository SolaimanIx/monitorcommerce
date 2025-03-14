@extends('layouts.app')
@section('content')
<style>
  .brand-list li, .category-list li{
    line-height: 40px;
  }

  .brand-list li .chk-brand , .category-list li .chk-category{
    width: 1rem;
    height: 1rem;
    color: #e4e4e4;
    border: 0.125rem solid currentColor;
    border-radius: 0;
    margin-right: 0.75rem;
  }
  .filled-heart{
    color: orange;
  }
</style>
<main class="pt-90">
    <section class="shop-main container d-flex pt-4 pt-xl-5">
        <div class="shop-sidebar side-sticky bg-body" id="shopFilter">
            <div class="aside-header d-flex d-lg-none align-items-center">
                <h3 class="text-uppercase fs-6 mb-0">Filter By</h3>
                <button class="btn-close-lg js-close-aside btn-close-aside ms-auto"></button>
            </div>

            <div class="pt-4 pt-lg-0"></div>

            <div class="accordion" id="categories-list">
                <div class="accordion-item mb-4 pb-3">
                    <h5 class="accordion-header" id="accordion-heading-1">
                        <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
                            data-bs-target="#accordion-filter-1" aria-expanded="true" aria-controls="accordion-filter-1">
                            Product Categories
                            <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                                <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                    <path
                                        d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                </g>
                            </svg>
                        </button>
                    </h5>
                    <div id="accordion-filter-1" class="accordion-collapse collapse show border-0"
                        aria-labelledby="accordion-heading-1" data-bs-parent="#categories-list">
                        <div class="accordion-body px-0 pb-0 pt-3">
                            <ul class="list list-inline mb-0">
                                @foreach($categories as $category)
                                <li class="list-item">
                                    <a href="{{ route('shop.index', ['category' => $category->name]) }}"
                                        class="menu-link py-1 d-flex align-items-center {{ $selectedCategory === $category->name ? 'fw-bold active' : '' }}">
                                        @if($selectedCategory === $category->name)
                                        <i class="fas fa-check me-2"></i>
                                        @endif
                                        {{ $category->name }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


            <div class="accordion" id="color-filters">
                <div class="accordion-item mb-4 pb-3">
                    <h5 class="accordion-header" id="accordion-heading-1">
                        <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
                            data-bs-target="#accordion-filter-2" aria-expanded="true" aria-controls="accordion-filter-2">
                            Color
                            <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                                <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                    <path
                                        d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                </g>
                            </svg>
                        </button>
                    </h5>
                    <div id="accordion-filter-2" class="accordion-collapse collapse show border-0"
                        aria-labelledby="accordion-heading-1" data-bs-parent="#color-filters">
                        <div class="accordion-body px-0 pb-0">
                            <div class="d-flex flex-wrap">
                                <a href="#" class="swatch-color js-filter" style="color: #0a2472"></a>
                                <a href="#" class="swatch-color js-filter" style="color: #d7bb4f"></a>
                                <a href="#" class="swatch-color js-filter" style="color: #282828"></a>
                                <a href="#" class="swatch-color js-filter" style="color: #b1d6e8"></a>
                                <a href="#" class="swatch-color js-filter" style="color: #9c7539"></a>
                                <a href="#" class="swatch-color js-filter" style="color: #d29b48"></a>
                                <a href="#" class="swatch-color js-filter" style="color: #e6ae95"></a>
                                <a href="#" class="swatch-color js-filter" style="color: #d76b67"></a>
                                <a href="#" class="swatch-color swatch_active js-filter" style="color: #bababa"></a>
                                <a href="#" class="swatch-color js-filter" style="color: #bfdcc4"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="accordion" id="size-filters">
                <div class="accordion-item mb-4 pb-3">
                    <h5 class="accordion-header" id="accordion-heading-size">
                        <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
                            data-bs-target="#accordion-filter-size" aria-expanded="true" aria-controls="accordion-filter-size">
                            Sizes
                            <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                                <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                    <path
                                        d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                </g>
                            </svg>
                        </button>
                    </h5>
                    <div id="accordion-filter-size" class="accordion-collapse collapse show border-0"
                        aria-labelledby="accordion-heading-size" data-bs-parent="#size-filters">
                        <div class="accordion-body px-0 pb-0">
                            <div class="d-flex flex-wrap">
                                <a href="#" class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">XS</a>
                                <a href="#" class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">S</a>
                                <a href="#" class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">M</a>
                                <a href="#" class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">L</a>
                                <a href="#" class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">XL</a>
                                <a href="#" class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">XXL</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Brand filters section (previously used for Categories) -->
            <div class="accordion" id="brand-filters">
                <div class="accordion-item mb-4 pb-3">
                    <h5 class="accordion-header" id="accordion-heading-brand">
                        <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
                            data-bs-target="#accordion-filter-brand" aria-expanded="true" aria-controls="accordion-filter-brand">
                            Brands
                            <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                                <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                    <path
                                        d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                </g>
                            </svg>
                        </button>
                    </h5>
                    <div id="accordion-filter-brand" class="accordion-collapse collapse show border-0"
                        aria-labelledby="accordion-heading-brand" data-bs-parent="#brand-filters">
                        <div class="search-field multi-select accordion-body px-0 pb-0">
                            <ul class="multi-select__list list-unstyled">
                                @foreach($brands as $brand)
                                <li class="search-suggestion__item multi-select__item text-primary">
                                    <a href="{{ route('shop.index', ['filter_brand' => $brand->name]) }}"
                                        class="d-flex w-100 text-decoration-none {{ $selectedBrand === $brand->name ? 'fw-bold' : '' }}">
                                        <span class="me-auto">{{ $brand->name }}</span>
                                        @if($selectedBrand === $brand->name)
                                        <i class="fas fa-check"></i>
                                        @endif
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Featured items / Sorting section -->
            <div class="accordion" id="featured-filters">
                <div class="accordion-item mb-4 pb-3">
                    <h5 class="accordion-header" id="accordion-heading-featured">
                        <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
                            data-bs-target="#accordion-filter-featured" aria-expanded="true" aria-controls="accordion-filter-featured">
                            Sort By
                            <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                                <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                    <path
                                        d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                </g>
                            </svg>
                        </button>
                    </h5>
                    <div id="accordion-filter-featured" class="accordion-collapse collapse show border-0"
                        aria-labelledby="accordion-heading-featured" data-bs-parent="#featured-filters">
                        <div class="search-field multi-select accordion-body px-0 pb-0">
                            <ul class="multi-select__list list-unstyled">
                                <li class="search-suggestion__item multi-select__item text-primary">
                                    <a href="{{ route('shop.index', array_merge(request()->except('sort'), ['sort' => null])) }}"
                                        class="d-flex w-100 text-decoration-none {{ $selectedSort === null ? 'fw-bold' : '' }}">
                                        <span class="me-auto">Default</span>
                                        @if($selectedSort === null)
                                        <i class="fas fa-check"></i>
                                        @endif
                                    </a>
                                </li>
                                <li class="search-suggestion__item multi-select__item text-primary">
                                    <a href="{{ route('shop.index', array_merge(request()->except('sort'), ['sort' => 'newest'])) }}"
                                        class="d-flex w-100 text-decoration-none {{ $selectedSort === 'newest' ? 'fw-bold' : '' }}">
                                        <span class="me-auto">New Arrivals</span>
                                        @if($selectedSort === 'newest')
                                        <i class="fas fa-check"></i>
                                        @endif
                                    </a>
                                </li>
                                <li class="search-suggestion__item multi-select__item text-primary">
                                    <a href="{{ route('shop.index', array_merge(request()->except('sort'), ['sort' => 'price_low'])) }}"
                                        class="d-flex w-100 text-decoration-none {{ $selectedSort === 'price_low' ? 'fw-bold' : '' }}">
                                        <span class="me-auto">Price: Low to High</span>
                                        @if($selectedSort === 'price_low')
                                        <i class="fas fa-check"></i>
                                        @endif
                                    </a>
                                </li>
                                <li class="search-suggestion__item multi-select__item text-primary">
                                    <a href="{{ route('shop.index', array_merge(request()->except('sort'), ['sort' => 'price_high'])) }}"
                                        class="d-flex w-100 text-decoration-none {{ $selectedSort === 'price_high' ? 'fw-bold' : '' }}">
                                        <span class="me-auto">Price: High to Low</span>
                                        @if($selectedSort === 'price_high')
                                        <i class="fas fa-check"></i>
                                        @endif
                                    </a>
                                </li>
                                <li class="search-suggestion__item multi-select__item text-primary">
                                    <a href="{{ route('shop.index', array_merge(request()->except('sort'), ['sort' => 'name_az'])) }}"
                                        class="d-flex w-100 text-decoration-none {{ $selectedSort === 'name_az' ? 'fw-bold' : '' }}">
                                        <span class="me-auto">Name: A-Z</span>
                                        @if($selectedSort === 'name_az')
                                        <i class="fas fa-check"></i>
                                        @endif
                                    </a>
                                </li>
                                <li class="search-suggestion__item multi-select__item text-primary">
                                    <a href="{{ route('shop.index', array_merge(request()->except('sort'), ['sort' => 'name_za'])) }}"
                                        class="d-flex w-100 text-decoration-none {{ $selectedSort === 'name_za' ? 'fw-bold' : '' }}">
                                        <span class="me-auto">Name: Z-A</span>
                                        @if($selectedSort === 'name_za')
                                        <i class="fas fa-check"></i>
                                        @endif
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


            <div class="accordion" id="price-filters">
                <div class="accordion-item mb-4">
                    <h5 class="accordion-header mb-2" id="accordion-heading-price">
                        <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
                            data-bs-target="#accordion-filter-price" aria-expanded="true" aria-controls="accordion-filter-price">
                            Price
                            <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                                <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                    <path
                                        d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                </g>
                            </svg>
                        </button>
                    </h5>
                    <div id="accordion-filter-price" class="accordion-collapse collapse show border-0"
                        aria-labelledby="accordion-heading-price" data-bs-parent="#price-filters">
                        <div class="price-filter-content">
                            <form id="price-filter-form" method="GET" action="{{ route('shop.index') }}">
                                <!-- Preserve existing filters -->
                                @foreach(request()->except(['min_price', 'max_price', 'page', 'price_range']) as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach

                                <div id="price-slider-container"
                                    data-min="{{ $minPrice }}"
                                    data-max="{{ $maxPrice }}"
                                    data-current-min="{{ $currentMinPrice }}"
                                    data-current-max="{{ $currentMaxPrice }}">
                                    <!-- The slider will be inserted here by JS -->
                                </div>

                                <input type="hidden" name="min_price" id="min_price" value="{{ $currentMinPrice }}">
                                <input type="hidden" name="max_price" id="max_price" value="{{ $currentMaxPrice }}">

                                <div class="price-range__info d-flex align-items-center mt-3">
                                    <div class="me-auto">
                                        <span class="text-secondary">Min Price: </span>
                                        <span class="price-range__min">${{ $currentMinPrice }}</span>
                                    </div>
                                    <div>
                                        <span class="text-secondary">Max Price: </span>
                                        <span class="price-range__max">${{ $currentMaxPrice }}</span>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-sm btn-primary">Apply Filter</button>
                                    @if(request()->has('min_price') || request()->has('max_price'))
                                    <a href="{{ route('shop.index', array_diff_key(request()->all(), ['min_price' => '', 'max_price' => '', 'price_range' => '', 'page' => ''])) }}"
                                        class="btn btn-sm btn-outline-secondary">Reset</a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="shop-list flex-grow-1">
            <div class="swiper-container js-swiper-slider slideshow slideshow_small slideshow_split" data-settings='{
            "autoplay": {
              "delay": 5000
            },
            "slidesPerView": 1,
            "effect": "fade",
            "loop": true,
            "pagination": {
              "el": ".slideshow-pagination",
              "type": "bullets",
              "clickable": true
            }
          }'>
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                            <div class="slide-split_text position-relative d-flex align-items-center"
                                style="background-color: #f5e6e0;">
                                <div class="slideshow-text container p-3 p-xl-5">
                                    <h2
                                        class="text-uppercase section-title fw-normal mb-3 animate animate_fade animate_btt animate_delay-2">
                                        Women's <br /><strong>ACCESSORIES</strong></h2>
                                    <p class="mb-0 animate animate_fade animate_btt animate_delay-5">Accessories are the best way to
                                        update your look. Add a title edge with new styles and new colors, or go for timeless pieces.</h6>
                                </div>
                            </div>
                            <div class="slide-split_media position-relative">
                                <div class="slideshow-bg" style="background-color: #f5e6e0;">
                                    <img loading="lazy" src="assets/images/shop/shop_banner3.jpg" width="630" height="450"
                                        alt="Women's accessories" class="slideshow-bg__img object-fit-cover" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                            <div class="slide-split_text position-relative d-flex align-items-center"
                                style="background-color: #f5e6e0;">
                                <div class="slideshow-text container p-3 p-xl-5">
                                    <h2
                                        class="text-uppercase section-title fw-normal mb-3 animate animate_fade animate_btt animate_delay-2">
                                        Women's <br /><strong>ACCESSORIES</strong></h2>
                                    <p class="mb-0 animate animate_fade animate_btt animate_delay-5">Accessories are the best way to
                                        update your look. Add a title edge with new styles and new colors, or go for timeless pieces.</h6>
                                </div>
                            </div>
                            <div class="slide-split_media position-relative">
                                <div class="slideshow-bg" style="background-color: #f5e6e0;">
                                    <img loading="lazy" src="assets/images/shop/shop_banner3.jpg" width="630" height="450"
                                        alt="Women's accessories" class="slideshow-bg__img object-fit-cover" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                            <div class="slide-split_text position-relative d-flex align-items-center"
                                style="background-color: #f5e6e0;">
                                <div class="slideshow-text container p-3 p-xl-5">
                                    <h2
                                        class="text-uppercase section-title fw-normal mb-3 animate animate_fade animate_btt animate_delay-2">
                                        Women's <br /><strong>ACCESSORIES</strong></h2>
                                    <p class="mb-0 animate animate_fade animate_btt animate_delay-5">Accessories are the best way to
                                        update your look. Add a title edge with new styles and new colors, or go for timeless pieces.</h6>
                                </div>
                            </div>
                            <div class="slide-split_media position-relative">
                                <div class="slideshow-bg" style="background-color: #f5e6e0;">
                                    <img loading="lazy" src="assets/images/shop/shop_banner3.jpg" width="630" height="450"
                                        alt="Women's accessories" class="slideshow-bg__img object-fit-cover" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container p-3 p-xl-5">
                    <div class="slideshow-pagination d-flex align-items-center position-absolute bottom-0 mb-4 pb-xl-2"></div>

                </div>
            </div>

            <div class="mb-3 pb-2 pb-xl-3"></div>

            <div class="d-flex justify-content-between mb-4 pb-md-2">
                <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                    <a href="{{ route('home.index') }}" class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
                    <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                    <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">The Shop</a>
                </div>

                <div class="shop-acs d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
                    <!-- Update the select dropdown to use the sort parameter -->
                    <select class="shop-acs__select form-select w-auto border-0 py-0 order-1 order-md-0"
                        aria-label="Sort Items" name="sort" onchange="window.location.href=`{{ route('shop.index') }}?sort=${this.value}`">
                        <option value="" {{ $selectedSort === null ? 'selected' : '' }}>Default Sorting</option>
                        <option value="newest" {{ $selectedSort === 'newest' ? 'selected' : '' }}>New Arrivals</option>
                        <option value="price_low" {{ $selectedSort === 'price_low' ? 'selected' : '' }}>Price, low to high</option>
                        <option value="price_high" {{ $selectedSort === 'price_high' ? 'selected' : '' }}>Price, high to low</option>
                        <option value="name_az" {{ $selectedSort === 'name_az' ? 'selected' : '' }}>Alphabetically, A-Z</option>
                        <option value="name_za" {{ $selectedSort === 'name_za' ? 'selected' : '' }}>Alphabetically, Z-A</option>
                    </select>

                    <div class="shop-asc__seprator mx-3 bg-light d-none d-md-block order-md-0"></div>

                    <div class="col-size align-items-center order-1 d-none d-lg-flex">
                        <span class="text-uppercase fw-medium me-2">View</span>
                        <button class="btn-link fw-medium me-2 js-cols-size" data-target="products-grid" data-cols="2">2</button>
                        <button class="btn-link fw-medium me-2 js-cols-size" data-target="products-grid" data-cols="3">3</button>
                        <button class="btn-link fw-medium js-cols-size" data-target="products-grid" data-cols="4">4</button>
                    </div>

                    <div class="shop-filter d-flex align-items-center order-0 order-md-3 d-lg-none">
                        <button class="btn-link btn-link_f d-flex align-items-center ps-0 js-open-aside" data-aside="shopFilter">
                            <svg class="d-inline-block align-middle me-2" width="14" height="10" viewBox="0 0 14 10" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_filter" />
                            </svg>
                            <span class="text-uppercase fw-medium d-inline-block align-middle">Filter</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="products-grid row row-cols-2 row-cols-md-3" id="products-grid">
                @foreach($products as $product)
                <div class="product-card-wrapper">
                    <div class="product-card mb-3 mb-md-4 mb-xxl-5">
                        <div class="pc__img-wrapper">
                            <div class="swiper-container background-img js-swiper-slider" data-settings='{"resizeObserver": true}'>
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <a href="{{ route('shop.product.details',['product_slug'=>$product->slug]) }}"><img loading="lazy" src="{{ asset('uploads/products')}}/{{$product->image}}" width="330"
                                                height="400" alt="{{$product->name}}" class="pc__img"></a>
                                    </div>
                                    <div class="swiper-slide">
                                        @foreach(explode(",",$product->images) as $gimg)
                                        <a href="{{ route('shop.product.details',['product_slug'=>$product->slug]) }}"><img loading="lazy" src="{{ asset('uploads/products') }}/{{ $gimg }}"
                                                width="330" height="400" alt="{$product->name}}" class="pc__img"></a>
                                        @endforeach
                                    </div>
                                </div>
                                <span class="pc__img-prev"><svg width="7" height="11" viewBox="0 0 7 11"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_prev_sm" />
                                    </svg></span>
                                <span class="pc__img-next"><svg width="7" height="11" viewBox="0 0 7 11"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_next_sm" />
                                    </svg></span>
                            </div>
                            @if(Cart::instance('cart')->content()->where('id', $product->id)->count() > 0)
                            <a href="{{ route('cart.index') }}" class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium btn-warning mb-3">Go to Cart</a>
                            @else
                            <form name="addtocart-form" method="post" action="{{ route('cart.add') }}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <input type="hidden" name="name" value="{{ $product->name }}">
                                <input type="hidden" name="price" value="{{ $product->sale_price == '' ? $product->regular_price : $product->sale_price }}">
                                <button type="submit"
                                    class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium"
                                    data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                            </form>
                            @endif
                        </div>

                        <div class="pc__info position-relative">
                            <p class="pc__category">{{ $product->category->name }}</p>
                            <h6 class="pc__title"><a href="{{ route('shop.product.details',['product_slug'=>$product->slug]) }}">{{ $product->name }}</a></h6>
                            <div class="product-card__price d-flex">
                                <span class="money price">
                                    @if($product->sale_price)
                                    <s>${{ $product->regular_price }}</s> ${{ $product->sale_price }}
                                    @else
                                    ${{ $product->regular_price }}
                                    @endif
                                </span>
                            </div>
                            <div class="product-card__review d-flex align-items-center">
                                <div class="reviews-group d-flex">
                                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_star" />
                                    </svg>
                                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_star" />
                                    </svg>
                                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_star" />
                                    </svg>
                                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_star" />
                                    </svg>
                                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_star" />
                                    </svg>
                                </div>
                                <span class="reviews-note text-lowercase text-secondary ms-1">8k+ reviews</span>
                            </div>
                            @if(Cart::instance('wishlist')->content()->where('id', $product->id)->count() > 0)
                            <button type="submit" class=" position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist filled-heart"
                                title="Add To Wishlist">
                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_heart" />
                                </svg>
                            </button>
                            @else
                            <form method="POST" action="{{ route('wishlist.add') }}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}" />
                                <input type="hidden" name="name" value="{{ $product->name }}" />
                                <input type="hidden" name="price" value="{{ $product->sale_price == '' ? $product->regular_price : $product->sale_price }}" />
                                <input type="hidden" name="quantity" value="1" />
                                <button type="submit" class=" position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist"
                                    title="Add To Wishlist">
                                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_heart" />
                                    </svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </section>
</main>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        try {
            // Get price slider container
            const sliderContainer = document.getElementById('price-slider-container');
            if (!sliderContainer) {
                console.error('Price slider container not found');
                return;
            }

            // Get slider configuration from data attributes
            const minPrice = parseInt(sliderContainer.dataset.min);
            const maxPrice = parseInt(sliderContainer.dataset.max);
            const currentMinPrice = parseInt(sliderContainer.dataset.currentMin);
            const currentMaxPrice = parseInt(sliderContainer.dataset.currentMax);

            // Create slider element
            const sliderElement = document.createElement('div');
            sliderElement.classList.add('price-range-slider');
            sliderContainer.appendChild(sliderElement);

            console.log('Creating slider with:', {
                min: minPrice,
                max: maxPrice,
                currentMin: currentMinPrice,
                currentMax: currentMaxPrice
            });

            // Initialize noUiSlider
            if (typeof noUiSlider !== 'undefined') {
                noUiSlider.create(sliderElement, {
                    start: [currentMinPrice, currentMaxPrice],
                    connect: true,
                    step: 1,
                    range: {
                        'min': minPrice,
                        'max': maxPrice
                    },
                    format: {
                        to: function(value) {
                            return Math.round(value);
                        },
                        from: function(value) {
                            return Math.round(value);
                        }
                    }
                });

                // Update hidden fields when slider values change
                sliderElement.noUiSlider.on('update', function(values, handle) {
                    const minValue = parseInt(values[0]);
                    const maxValue = parseInt(values[1]);

                    document.getElementById('min_price').value = minValue;
                    document.getElementById('max_price').value = maxValue;
                    document.querySelector('.price-range__min').textContent = '$' + minValue;
                    document.querySelector('.price-range__max').textContent = '$' + maxValue;
                });
            } else {
                // Fallback to Bootstrap Slider if noUiSlider is not available
                $(sliderElement).slider({
                    min: minPrice,
                    max: maxPrice,
                    step: 1,
                    value: [currentMinPrice, currentMaxPrice],
                    tooltip: 'hide'
                }).on('slide', function(slideEvt) {
                    document.getElementById('min_price').value = slideEvt.value[0];
                    document.getElementById('max_price').value = slideEvt.value[1];
                    document.querySelector('.price-range__min').textContent = '$' + slideEvt.value[0];
                    document.querySelector('.price-range__max').textContent = '$' + slideEvt.value[1];
                });
            }
        } catch (e) {
            console.error("Error initializing price slider:", e);

            // Create a simple fallback with two number inputs
            const container = document.getElementById('price-slider-container');
            if (container) {
                container.innerHTML = `
                <div class="row g-2">
                    <div class="col">
                        <label for="min_price_input" class="form-label small">Min Price ($)</label>
                        <input type="number" class="form-control form-control-sm" id="min_price_input" 
                               value="{{ $currentMinPrice }}" min="{{ $minPrice }}" max="{{ $maxPrice }}"
                               onchange="document.getElementById('min_price').value=this.value; document.querySelector('.price-range__min').textContent='$'+this.value;">
                    </div>
                    <div class="col">
                        <label for="max_price_input" class="form-label small">Max Price ($)</label>
                        <input type="number" class="form-control form-control-sm" id="max_price_input" 
                               value="{{ $currentMaxPrice }}" min="{{ $minPrice }}" max="{{ $maxPrice }}"
                               onchange="document.getElementById('max_price').value=this.value; document.querySelector('.price-range__max').textContent='$'+this.value;">
                    </div>
                </div>
            `;
            }
        }
    });
</script>
@endpush