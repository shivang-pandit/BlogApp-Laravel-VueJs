<template>
    <div>
        <!-- BANNER -->
		<section class="banner_sec">
			<div class="container">
				<div class="row">
					<div class="col-12 col-md-10 col-lg-8">
						<div class="row">
							<div class="col-12 col-md-4 col-lg-4" v-for="(category, i) in categories" :key="i" v-if="categories.length">
								<a @click="$router.push(`/blogs?category=${category.id}`)">								
									<div class="banner_box">
										<i class="fab fa-laravel"></i>
										<h3 class="banner_box_h3">{{category.name}}</h3>
									</div>
								</a>
							</div>

							<!-- <div class="col-12 col-md-4 col-lg-4">
								<a href="">
									<div class="banner_box">
										<i class="fas fa-code"></i>
										<h3 class="banner_box_h3">Developers</h3>
										<p>The Toptal Blog is the top hub for developers.</p>
									</div>
								</a>
							</div>

							<div class="col-12 col-md-4 col-lg-4">
								<a href="">
									<div class="banner_box">
										<i class="fas fa-desktop"></i>
										<h3 class="banner_box_h3">Designers</h3>
										<p>The Toptal Blog is the top hub for developers.</p>
									</div>
								</a>
							</div>

							<div class="col-12 col-md-4 col-lg-4">
								<a href="">
									<div class="banner_box">
										<i class="fas fa-project-diagram"></i>
										<h3 class="banner_box_h3">Project Managers</h3>
										<p>The Toptal Blog is the top hub for developers.</p>
									</div>
								</a>
							</div>

							<div class="col-12 col-md-4 col-lg-4">
								<a href="">
									<div class="banner_box">
										<i class="fab fa-laravel"></i>
										<h3 class="banner_box_h3">Laravel</h3>
										<p>The Toptal Blog is the top hub for developers.</p>
									</div>
								</a>
							</div>

							<div class="col-12 col-md-4 col-lg-4">
								<a href="">
									<div class="banner_box">
										<i class="fab fa-sketch"></i>
										<h3 class="banner_box_h3">Product Managers</h3>
										<p>The Toptal Blog is the top hub for developers.</p>
									</div>
								</a>
							</div> -->
						</div>
					</div>
				</div>
			</div>
		</section>
        <!-- body -->
        <div class="home_body">
			<div class="container">
				<div class="latest_post">
					<div class="latest_post_top">
						<h1 class="latest_post_h1 brdr_line">Latest Blog</h1>
					</div>
					<div class="row">
						<div class="col-12 col-md-6 col-lg-4" v-for="(topBlog,i) in topBlogs" :key="i" v-if="topBlogs.length">							
								<div class="home_card">
									<a @click="$router.push(`/blog_detail/${topBlog.id}`)">
										<div class="home_card_top">
											<img :src="topBlog.image" alt="image">
										</div>
									</a>
									<div class="home_card_bottom">
										<div class="post_tags">
											<ul class="post_tags_ul" v-if="topBlog.categories.length">
												<li v-for="(category, i) in topBlog.categories" :key="i">
													<a @click="$router.push(`/blogs?category=${category.id}`)">{{category.name}}</a>
												</li>
											</ul>
											<a @click="$router.push(`/blog_detail/${topBlog.id}`)">
												<h2 class="home_card_h2">{{topBlog.title}}</h2>
											</a>
											<p class="post_p">
												{{topBlog.description.substr(0, 200)+'...'}}
											</p>
											<div class="home_card_bottom_tym">
												<div class="home_card_btm_left">
													<img src="images/user_icon.png" alt="image">
												</div>
												<div class="home_card_btm_r8">
													<a @click="$router.push(`/blogs?user=${topBlog.user.id}`)"><p class="author_name">{{topBlog.user.full_name}}</p></a>
													<ul class="home_card_btm_r8_ul">
														<li>{{moment(topBlog.created_at).format('DD MMM, YYYY')}}</li>
														<li><span class="dot"></span>3 Min Read</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>							
						</div>
						<!-- <div class="col-12 col-md-6 col-lg-4">
							<a href="blog_post.html">
								<div class="home_card">
									<div class="home_card_top">
										<img src="img/card2.jpg" alt="image">
									</div>
									<div class="home_card_bottom">
										<div class="home_card_bottom_text">
											<ul class="home_card_bottom_text_ul">
												<li>
													<a href="blog_post.html">engineering</a>
													<span><i class="fas fa-angle-right"></i></span>
												</li>
												<li>
													<a href="blog_post.html">data science and database</a>
												</li>
											</ul>
											<a href="blog_post.html">
												<h2 class="home_card_h2">Semi-supervised Image Classification with Unlabeled Data</h2>
											</a>
											<p class="post_p">
												Supervised learning is the key to computer vision and deep learning. However, what happens when you don’t have access to large, human-labeled datasets?

												In this article, Toptal Computer Vision Developer Urwa Muaz demonstrates the potential of semi-supervised image classification using unlabeled datasets.
											</p>
											<div class="home_card_bottom_tym">
												<div class="home_card_btm_left">
													<img src="img/man1.jpg" alt="image">
												</div>
												<div class="home_card_btm_r8">
												<a href="contact_me.html"><p class="author_name">Amy Sept</p></a>
													<ul class="home_card_btm_r8_ul">
														<li>Dec 4, 2019</li>
														<li><span class="dot"></span>3 Min Read</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</a>
						</div>
						<div class="col-12 col-md-6 col-lg-4">
							<a href="blog_post.html">
								<div class="home_card">
									<div class="home_card_top">
										<img src="img/card1.jpg" alt="image">
									</div>
									<div class="home_card_bottom">
										<div class="home_card_bottom_text">
											<ul class="home_card_bottom_text_ul">
												<li>
													<a href="blog_post.html">engineering</a>
													<span><i class="fas fa-angle-right"></i></span>
												</li>
												<li>
													<a href="blog_post.html">data science and database</a>
												</li>
											</ul>
											<a href="blog_post.html">
												<h2 class="home_card_h2">Semi-supervised Image Classification with Unlabeled Data</h2>
											</a>
											<p class="post_p">
												Supervised learning is the key to computer vision and deep learning. However, what happens when you don’t have access to large, human-labeled datasets?

												In this article, Toptal Computer Vision Developer Urwa Muaz demonstrates the potential of semi-supervised image classification using unlabeled datasets.
											</p>
											<div class="home_card_bottom_tym">
												<div class="home_card_btm_left">
													<img src="img/man1.jpg" alt="image">
												</div>
												<div class="home_card_btm_r8">
												<a href="contact_me.html"><p class="author_name">Amy Sept</p></a>
													<ul class="home_card_btm_r8_ul">
														<li>Dec 4, 2019</li>
														<li><span class="dot"></span>3 Min Read</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</a>
						</div>
						<div class="col-12 col-md-6 col-lg-4">
							<a href="blog_post.html">
								<div class="home_card">
									<div class="home_card_top">
										<img src="img/card3.jpg" alt="image">
									</div>
									<div class="home_card_bottom">
										<div class="home_card_bottom_text">
											<ul class="home_card_bottom_text_ul">
												<li>
													<a href="blog_post.html">engineering</a>
													<span><i class="fas fa-angle-right"></i></span>
												</li>
												<li>
													<a href="blog_post.html">data science and database</a>
												</li>
											</ul>
											<a href="blog_post.html">
												<h2 class="home_card_h2">Semi-supervised Image Classification with Unlabeled Data</h2>
											</a>
											<p class="post_p">
												Supervised learning is the key to computer vision and deep learning. However, what happens when you don’t have access to large, human-labeled datasets?

												In this article, Toptal Computer Vision Developer Urwa Muaz demonstrates the potential of semi-supervised image classification using unlabeled datasets.
											</p>
											<div class="home_card_bottom_tym">
												<div class="home_card_btm_left">
													<img src="img/man1.jpg" alt="image">
												</div>
												<div class="home_card_btm_r8">
												<a href="contact_me.html"><p class="author_name">Amy Sept</p></a>
													<ul class="home_card_btm_r8_ul">
														<li>Dec 4, 2019</li>
														<li><span class="dot"></span>3 Min Read</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</a>
						</div>
						<div class="col-12 col-md-6 col-lg-4">
							<a href="blog_post.html">
								<div class="home_card">
									<div class="home_card_top">
										<img src="img/card2.jpg" alt="image">
									</div>
									<div class="home_card_bottom">
										<div class="home_card_bottom_text">
											<ul class="home_card_bottom_text_ul">
												<li>
													<a href="blog_post.html">engineering</a>
													<span><i class="fas fa-angle-right"></i></span>
												</li>
												<li>
													<a href="blog_post.html">data science and database</a>
												</li>
											</ul>
											<a href="blog_post.html">
												<h2 class="home_card_h2">Semi-supervised Image Classification with Unlabeled Data</h2>
											</a>
											<p class="post_p">
												Supervised learning is the key to computer vision and deep learning. However, what happens when you don’t have access to large, human-labeled datasets?

												In this article, Toptal Computer Vision Developer Urwa Muaz demonstrates the potential of semi-supervised image classification using unlabeled datasets.
											</p>
											<div class="home_card_bottom_tym">
												<div class="home_card_btm_left">
													<img src="img/man1.jpg" alt="image">
												</div>
												<div class="home_card_btm_r8">
												<a href="contact_me.html"><p class="author_name">Amy Sept</p></a>
													<ul class="home_card_btm_r8_ul">
														<li>Dec 4, 2019</li>
														<li><span class="dot"></span>3 Min Read</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</a>
						</div>
						<div class="col-12 col-md-6 col-lg-4">
							<a href="blog_post.html">
								<div class="home_card">
									<div class="home_card_top">
										<img src="img/card1.jpg" alt="image">
									</div>
									<div class="home_card_bottom">
										<div class="home_card_bottom_text">
											<ul class="home_card_bottom_text_ul">
												<li>
													<a href="blog_post.html">engineering</a>
													<span><i class="fas fa-angle-right"></i></span>
												</li>
												<li>
													<a href="blog_post.html">data science and database</a>
												</li>
											</ul>
											<a href="blog_post.html">
												<h2 class="home_card_h2">Semi-supervised Image Classification with Unlabeled Data</h2>
											</a>
											<p class="post_p">
												Supervised learning is the key to computer vision and deep learning. However, what happens when you don’t have access to large, human-labeled datasets?

												In this article, Toptal Computer Vision Developer Urwa Muaz demonstrates the potential of semi-supervised image classification using unlabeled datasets.
											</p>
											<div class="home_card_bottom_tym">
												<div class="home_card_btm_left">
													<img src="img/man1.jpg" alt="image">
												</div>
												<div class="home_card_btm_r8">
												<a href="contact_me.html"><p class="author_name">Amy Sept</p></a>
													<ul class="home_card_btm_r8_ul">
														<li>Dec 4, 2019</li>
														<li><span class="dot"></span>3 Min Read</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</a>
						</div> -->
					</div>
				</div>
			</div>
					<!-- PAGINATION -->
			<!-- <div class="pagination">
				<ul class="pagination_ul d-flex">
					<li>
						<a href="">
							<i class="fas fa-chevron-left"></i>
						</a>
					</li>
					<li>
						<a href="">1</a>
					</li>
					<li>
						<a href="">2</a>
					</li>
					<li>
						<a href="">3</a>
					</li>
					<li>
						<a href="">
							<i class="fas fa-chevron-right"></i>
						</a>
					</li>
				</ul>
			</div> -->
			<!-- PAGINATION -->
		</div>
    </div>
</template>
<script>
import moment from 'moment'
 export default {
     data() {
         return {
            categories: [],
			topBlogs:[],
			moment: moment
         }
     },
     async created() { 
         const [categories, topBlogs] = await Promise.all([
            this.callApi('get', 'app/category'),
            this.callApi('get', 'app/blog/get_top'),
        ]);
        this.categories = categories.data
        this.topBlogs = topBlogs.data
     }
 }
</script>