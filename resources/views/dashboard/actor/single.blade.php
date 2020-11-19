@include('dashboard.layout.header')


<div class="hero hero3">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<!-- <h1> movie listing - list</h1>
				<ul class="breadcumb">
					<li class="active"><a href="#">Home</a></li>
					<li> <span class="ion-ios-arrow-right"></span> movie listing</li>
				</ul> -->
			</div>
		</div>
	</div>
</div>
<!-- celebrity single section-->

<div class="page-single movie-single cebleb-single">
	<div class="container">
		<div class="row ipad-width">
			<div class="col-md-4 col-sm-12 col-xs-12">
				<div class="mv-ceb">
					<img src="{{ $icon[0]->path }}" alt="">
				</div>
			</div>
			<div class="col-md-8 col-sm-12 col-xs-12">
				<div class="movie-single-ct">
					<h1 class="bd-hd">{{ $actor->name }}</h1>
					<p class="ceb-single">{{ $actor->role }}</p>
					<div class="social-link cebsingle-socail">
						<a href="{{URL::current()}}">{{ $actor->name }}</i></a>
					</div>
					<div class="movie-tabs">
						<div class="tabs">
							<ul class="tab-links tabs-mv">
								<li class="active"><a href="#overviewceb">Overview</a></li>
								<li><a href="#mediaceb"> PHOTOS</a></li> 
								<li><a href="#filmography">Works</a></li>                        
							</ul>
						    <div class="tab-content">
						        <div id="overviewceb" class="tab active">
						            <div class="row">
						            	<div class="col-md-8 col-sm-12 col-xs-12">
						            		<p>{{ $actor->description }}
						            		
						            	</div>
						            	<div class="col-md-4 col-xs-12 col-sm-12">
						            		<div class="sb-it">
						            			<h6>Fullname:  </h6>
						            			<p><a href="#">{{$actor->name }}</a></p>
						            		</div>
						            		@if ( $actor->DateOfBirth) 
						            		<div class="sb-it">
						            			<h6>Date of Birth: </h6>
						            			<p>{{$actor->DateOfBirth }}</p>
						            		</div>
						            		@endif
						            		@if ( $actor->country) 
							            		<div class="sb-it">
							            			<h6>Country:  </h6>
							            			<p> {{$actor->country }} </p>
							            		</div>
						            		@endif
						            		<div class="ads">
												<img src="images/uploads/ads1.png" alt="">
											</div>
						            	</div>
						            </div>
						        </div>
						        
						        <div id="mediaceb" class="tab">
						        	<div class="row">
						        		
										<div class="title-hd-sm">
											<h4>Photos</h4>
										</div>
										<div class="mvsingle-item">
											@foreach ($photos as $photo)
												    <a class="img-lightbox"  data-fancybox-group="gallery"  href="{{ $photo->path }}" ><img width="100" height="100" src="{{ $photo->path }}" alt="{{$actor->name}}"></a>
										    @endforeach
										</div>
						        	</div>
					       	 	</div>
					       	 	<div id="filmography" class="tab">
						        	<div class="row">
						            	<div class="rv-hd">
						            		<div>
						            			<h3>Works of</h3>
					       	 					<h2>{{ $actor->name }}</h2>
						            		</div>
										
						            	</div>
						            	<div class="topbar-filter">
											<p>Found <span>{{$actorCount}} movies</span> in total</p>
											
										</div>
										<!-- movie cast -->
										<div class="mvcast-item">
											@foreach ($actor->movies as $movie)
											<div class="cast-it">
												<div class="cast-left cebleb-film">
													<img width="55" height="77" src="{{ $movie->poster_path }}" alt="">
													<div>
														<a href="#">{{$movie->title}} </a>
														<div class="time">{{
															str_split($movie->description, 70)[0]
														}} ...</div>
													</div>
													
												</div>
												<p>... {{$movie->release_date}}</p>
											</div>
										    @endforeach											
										</div>
						            </div>
					       	 	</div>
						    </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</div>
<!-- celebrity single section-->


@include('dashboard.layout.footer')