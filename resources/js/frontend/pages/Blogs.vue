<template>
    <div>
        <!-- body -->
        <div class="home_body">
			<div class="container">
				<div class="latest_post">
					<div class="latest_post_top">
						<h1 class="latest_post_h1 brdr_line">Blogs</h1>
					</div>
					<div class="row">
						<div class="col-12 col-md-6 col-lg-4" v-for="(blog,i) in blogs" :key="i" v-if="blogs.length">							
								<div class="home_card">									
									<a @click="$router.push(`/blog_detail/${blog.id}`)">
										<div class="home_card_top">										
											<img :src="blog.image" alt="image" @click="$router.push(`/blog_detail/${blog.id}`)">										
										</div>
									</a>
									<div class="home_card_bottom">
										<div class="post_tags">
											<ul class="post_tags_ul" v-if="blog.categories.length">
												<li v-for="(category, i) in blog.categories" :key="i">
													<a @click="getFilter('category='+category.id)">{{category.name}}</a>
												</li>
											</ul>
											<a @click="$router.push(`/blog_detail/${blog.id}`)">
												<h2 class="home_card_h2">{{blog.title}}</h2>
											</a>
											<p class="post_p">
												{{blog.description.substr(0, 200)+'...'}}
											</p>
											<div class="home_card_bottom_tym">
												<div class="home_card_btm_left">
													<img src="images/user_icon.png" alt="image">
												</div>
												<div class="home_card_btm_r8">
												<a @click="getFilter('user='+blog.user.id)"><p class="author_name">{{blog.user.full_name}}</p></a>
													<ul class="home_card_btm_r8_ul">
														<li>{{moment(blog.created_at).format('DD MMM, YYYY')}}</li>
														<li><span class="dot"></span>3 Min Read</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>							
						</div>
					</div>
				</div>
			</div>
			<div class="pagination_block">
				<Page :total="pageInfo.total" :current="pageInfo.current_page" :page-size="parseInt(pageInfo.per_page)" @on-change="getFilter" v-if="pageInfo" />
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
			blogs:[],
			moment: moment,
			pageInfo: null,
			total:6,
			category:'',
			page:1,
			user:'',
			tag:'',
		}
	},
	methods:{
		async getFilter(filter='') {					
			let queryParam = {};

			if(this.$route.query.category) {
				queryParam['category'] = this.$route.query.category;				
			}
			
			if(this.$route.query.tag) {
				queryParam['tag'] = this.$route.query.tag;				
			}

			if(this.$route.query.user) {
				queryParam['user'] = this.$route.query.user;				
			}
			
			if(!Number.isInteger(filter) && filter.search("category=")!= -1) {
				queryParam['category'] = filter.split('category=')[1];	
				this.category = filter.split('category=')[1];	
			}

			if(!Number.isInteger(filter) && filter.search("tag=")!= -1) {
				queryParam['tag'] = filter.split('tag=')[1];	
				this.category = filter.split('tag=')[1];	
			}

			if(!Number.isInteger(filter) && filter.search("user=")!= -1) {
				queryParam['user'] = filter.split('user=')[1];	
				this.user = filter.split('user=')[1];	
			}	

			if(Number.isInteger(filter)) {				
				queryParam['page'] = filter;	
				this.page = filter			
			}						
			
			console.log(queryParam);
			if(Object.keys(queryParam).length !== 0) {
				this.$router.replace({ path:'blogs', query: queryParam }).catch(()=>{});				
			}
			this.getBlogData()
		},
		async getBlogData() {		
			let url = `/app/blog/get_all?page=${this.page}&total=${this.total}`;
			if(this.category) {
				url += `&category=${this.category}`;
			}

			if(this.user) {
				url += `&user_id=${this.user}`;
			}

			if(this.tag) {
				url += `&tag_id=${this.tag}`;
			}
			
			const blogs = await this.callApi('get', url)
			console.log(blogs);
			if(blogs.status == 200) {
				this.blogs = blogs.data.data
				this.pageInfo = blogs.data                    
			} else {
				this.swr();
			}
		}
	},
	async created() { 		
		let queryParam = {};
		if(this.$route.query.category) {
			this.category = this.$route.query.category			
		}

		if(this.$route.query.page) {
			this.page = this.$route.query.page			
		}

		if(this.$route.query.user) {
			this.user = this.$route.query.user			
		}

		if(this.$route.query.tag) {
			this.tag = this.$route.query.tag			
		}

		this.getBlogData();
		const [categories, blogs] = await Promise.all([
			this.callApi('get', '/app/category'),
		]);
		this.categories = categories.data		
	}
 }
</script>