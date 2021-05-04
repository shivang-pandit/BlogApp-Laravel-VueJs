<template>
    <div>
        <!-- BANNER -->
		<div class="blog_banner contact_banner">
			<div class="container">
				<div class="blog_banner_info">
					<div class="blog_banner_info_title pad_b20">
						<h2>Contact US</h2>
					</div>
					<div class="blog_title_btm">
						<ul class="blog_title_btm_ul dis_flx">
							<li>
								<a href="/">
									Home<i class="fa fa-angle-right"></i>
								</a>
							</li>
							<li>
								<a href="/contact">
									Contact
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- BANNER -->

		<!-- BODY -->		
		<div class="contact_page">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-12 col-md-8 col-lg-5">
						<div class="cmnt_frm" v-if="!isSuccess">
									<h2 class="post_dtls_title2 pad_b20" style=" text-align: center;font-size: 28px;">Contact Me</h2>
								<div class="cmnt_frm_all">
									<div class="row">
										<div class="col-12 col-md-12 col-lg-12">
											<div class="cmnt_input">
												<p>NAME</p>
												<input type="text" placeholder="Enter your name" v-model="data.name" required>
											</div>
										</div>
										<div class="col-12 col-md-12 col-lg-12">
											<div class="cmnt_input">
												<p>E-MAIL</p>
												<input type="text" placeholder="Enter your E-MAIL" v-model="data.email" required>
											</div>
										</div>
										<div class="col-12 col-md-12 col-lg-12">
											<div class="cmnt_input">
												<p class="mar_b10">MESSAGE</p>
												<textarea placeholder="Type your comment" name="message" required="" v-model="data.message"></textarea>
											</div>
										</div>
										<div class="dtls_frm_btn mar_t20">
											<button class="btn1" @click="add" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'sending...':'Send'}}</button>
										</div>
									</div>
								</div>
							</div>
						<div class="sucess" v-if="isSuccess">
							<h1>Thank you For your inquiry!</h1>
							<p>Your request is successfully Submitted! we will try to contact you as soon as possible!</p>
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
			data: {
				name: '',
				email: '',
				message: '',
			},
            categories: [],
			topBlogs:[],
			moment: moment,
			isAdding: false,
			isSuccess: false,
         }
	 },
	 methods: {
		async add(){                        						
            if(this.data.name.trim()=='') return this.e('Name is required!')
            if(this.data.email.trim()=='') return this.e('Email is required!')
			if(this.data.message.trim()=='') return this.e('Message is required!')            
			
            this.isAdding=true
            const res = await this.callApi('post', 'inquiry/create', this.data);            
            if(res.status == 201) {                                              
				this.isAdding = false
				this.isSuccess = true
				this.data.name = ''
				this.data.email = ''
				this.data.message = ''
            } else if(res.status == 422){
               if(res.data.error){
                    this.e(res.data.error);
                }
                this.isAdding = false 
            } else {
                this.swr()
                this.isAdding = false 
            }
        },
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