<template>
    <div>
        <!-- BANNER -->
		<div class="blog_banner">
			<div class="container">
				<div class="blog_banner_info">
					<div class="blog_banner_info_title pad_b20">
						<h2>About Me</h2>
					</div>
					<div class="blog_title_btm">
						<ul class="blog_title_btm_ul dis_flx">
							<li>
								<a href="/">
									Home<i class="fa fa-angle-right"></i>
								</a>
							</li>
							<li>
								<a href="/about">
									About
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- BANNER -->

		<!-- BODY -->
		<div class="author_page">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-12 col-md-10 col-lg-10">
						<div class="row">
							<div class="col-12 col-md-3 col-lg-3">
								<div class="me_prfl_left">
									<div class="me_prfl_left_top_img">
										<img src="images/about_me.JPG" alt="image">
									</div>
									<div class="me_cntct">
										<h4 class="me_cntct_title">Contact Info</h4>
										<ul class="me_cntct_ul">
											<li>
												<i class="fa fa-envelope"></i> Email: shivang512@gmail.com
											</li>
											<li class="me_phn">
												<i class="fa fa-phone"></i>
												Phone: 777 800 1552
											</li>
										</ul>
									</div>
									<div class="me_social mar_t30">
										<ul class="me_social_ul d-flex">
											<li>
												<a href="">
													<i class="fab fa-facebook-f"></i>
												</a>
											</li>
											<li>
												<a href="">
													<i class="fab fa-google-plus-g"></i>
												</a>
											</li>
											<li>
												<a href="">
													<i class="fab fa-twitter"></i>
												</a>
											</li>
											<li>
												<a href="">
													<i class="fab fa-linkedin-in"></i>
												</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-9 col-lg-9">
								<div class="me_prfl_r8">
									<div class="me_prfl_name">
										<h2 class="me_cntct_name">Shivang Pandit</h2>
										<h4 class="me_prfsn_title mar_b10">Web Developer</h4>
									</div>
								
									<div class="me_prfl_descrb">
										<p class="me_prfl_descrb_text">
											The foundations and aspirations of our business remain true to those established by our visionary founders, and their innovation and energy continue to be our inspiration. Our passion and entrepreneurial culture will ensure that we deliver for our customers in safety, quality and assurance – today and in the future.
										</p>
										<p class="me_prfl_descrb_text">
											Over a century later, we maintain his ETL mark of quality, and continue to establish new standards in quality to protect consumers and our clients’ reputations across the world. Today we are a global force, operating in over 100 countries, offering Total Quality Assurance expertise, delivered consistently with precision, pace and passion, enabling our customers to power ahead safely.
										</p>
									</div>
									<div class="me_all_info_sec mar_t30">
										<div class="me_all_info_lft">
											<div class="me_all_info_lft_title">
												<h4 class="me_cntct_title me_skil">My Skill</h4>
											</div>
											<div class="progrsbar_all">
												<div class="progrsbar_single">
													<div class="progrsbar_single_top">
														<p class="prgrs_title">Web Development</p>
														<p class="prgrs_prcntg">98%</p>
													</div>
													<div class="prgrs_line">
														 <div class="progress">
														    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:98%">
														    </div>
											 			 </div>
													</div>
												</div>
												<div class="progrsbar_single">
													<div class="progrsbar_single_top">
														<p class="prgrs_title">Laravel</p>
														<p class="prgrs_prcntg">88%</p>
													</div>
													<div class="prgrs_line">
														 <div class="progress">
														    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:88%">
														    </div>
											 			 </div>
													</div>
												</div>
												<div class="progrsbar_single">
													<div class="progrsbar_single_top">
														<p class="prgrs_title">Opencart</p>
														<p class="prgrs_prcntg">92%</p>
													</div>
													<div class="prgrs_line">
														 <div class="progress">
														    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:92%">
														    </div>
											 			 </div>
													</div>
												</div>
												<div class="progrsbar_single">
													<div class="progrsbar_single_top">
														<p class="prgrs_title">Vue.Js</p>
														<p class="prgrs_prcntg">78%</p>
													</div>
													<div class="prgrs_line">
														 <div class="progress">
														    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:84%">
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
			</div>
		</div>
		<!-- BODY -->
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