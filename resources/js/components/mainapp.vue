<template>
    <div>
      <div style="position: relative;">
			<div class="header">
				<div class="menu_all" id="myHeader">
					<div class="container">
						<div class="row align-items-center">
							<div class="col-4 col-md-4 col-lg-4">
								<div class="logo">
									<a href="/">
										<div class="logo_img">
											<!-- <img src="img/logo.png" alt="Blogs"> -->
											<h1>Blogs</h1>
										</div>
									</a>
								</div>
							</div>
							<div class="col-8 col-md-8 col-lg-8">
								<div class="menu_right d-flex">
									<div class="menu_right_list">
										<ul class="menu_right_ul d-flex">
											<li class="dis_fx_cntr">
												<a href="/">HOME</a>
											</li>
											<li class="dis_fx_cntr">
												<a href="/blogs">Blogs</a>
											</li>											
											<!-- <li v-for="(category, i) in cats" :key="i" v-if="cats">
												<a :href="'blogs?category='+category.id">{{category.name}}</a>
											</li> -->
											<li>
												<a href="/about">about</a>
											</li>
											
											<li>
												<a href="/contact">CONTACT</a>
											</li>
										</ul>
									</div>
									<div class="menu_srch d-flex">
										<i class="fas fa-search search_btn"></i>
										<!-- SEARCH INPUT -->
										<div class="header_serch dis_none">
											<div class="header_serch_input">
												<input type="" name="" placeholder="Search">
											</div>
											<div class="header_serch_i">
												<i class="fas fa-search"></i>
											</div>
										</div>
										<!-- SEARCH INPUT -->
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- HEADER -->
    	<router-view></router-view>
		<!-- FOOTER -->
		<div class="footer_section">
			<!-- <div class="footer_section_social">
				<ul class="footer_section_social_ul">
					   <li>
                            <a href=""><i class="fab fa-facebook-f"></i></a>
                        </li>

                        <li>
                            <a href=""><i class="fab fa-instagram"></i></a>
                        </li>

                        <li>
                            <a href=""><i class="fab fa-twitter"></i></a>
                        </li>

                        <li>
                            <a href=""><i class="fab fa-google-plus-g"></i></a>
                        </li>
				</ul>
			</div> -->
			<div class="footer_section_mnu">
				<ul class="footer_section_ul">
					<li>
						<a href="/">Home</a>
					</li>					
					<li>
						<a href="/about">About</a>
					</li>
					<li>
						<a href="/contact">Contact</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="footer_copy_right">
			<p>©2020 Shivang. All rights reserved</p>
		</div>
		<!-- FOOTER -->
    </div>
</template>
<script>
export default {
	data() {
         return {
            cats: [],
         }
     },
     async created() {
          let cats = await this.callApi('get', '/app/category')
		  this.cats = cats.data
     }
}
</script>