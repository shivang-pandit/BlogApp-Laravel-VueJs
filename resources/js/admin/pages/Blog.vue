<template>
    <div>
       <div class="content">
			<div class="container-fluid">					
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Blog <Button @click="addModal=true" v-if="isWritePermitted"><Icon type="md-add" />Add blog</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>Id</th>
                                <th>Image</th>								
								<th>Title</th>                                
                                <th>Create At</th>								
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(blog, i) in blogs" :key="i" >
								<td>{{blog.id}}</td>
                                <td class="table_image">
                                    <img :src="blog.image" v-if="blog.image"/>
                                </td>				
                                <td class="_table_name">{{blog.title}}</td>	                                			
								<td>{{blog.created_at}}</td>	                                
								<td>									
									<Button class="_btn _action_btn edit_btn1" type="info" @click="showEditModal(blog, i)" v-if="isUpdatePermitted">Edit</button>									
									<Button class="_btn _action_btn make_btn1" type="error" @click="showDeleteModal(blog,i)" :loading="blog.isDeleting" v-if="isDeletePermitted">Delete</button>
								</td>
							</tr>
								<!-- ITEMS -->
						</table>
					</div>
				</div>
				<Page :total="pageInfo.total" :current="pageInfo.current_page" :page-size="parseInt(pageInfo.per_page)" @on-change="getBlogData" v-if="pageInfo" />
                <!-- Tag add modal -->
                <Modal
                    v-model="addModal"
                    title="Add Blog"
                    :mask-closable="false"
                    :closable="false" style="width:100%">
                    
                    <div class="space">
                        <Input v-model="data.title" placeholder="Title"/>
                    </div>
                    <div class="space">
                        <Upload 
                        ref="uploads"
                        type="drag" 
                        action="/app/common/upload" 
                        :on-success="handleSuccess"
                        :on-error="handleError"
                        :format="['jpg','jpeg','png']"
                        :max-size="2048"
                        :on-format-error="handleFormatError"
                        :on-exceeded-size="handleMaxSize"
                        :headers="{ 'x-csrf-token': token }" :data="{ 'folder_path': folder}" >
                        <div style="padding: 20px 0">
                            <Icon type="ios-cloud-upload" size="52" style="color:#3399ff"></Icon>
                            <p>Click or drag files here to upload feature image</p>
                        </div>
                        </Upload>
                        <div class="demo-upload-list" v-if="data.image">
                            <img :src="`${data.image}`" />
                            <div class="demo-upload-list-cover">
                            <Icon type="ios-trash-outline" @click="deleteImage"></Icon>
                            </div>
                        </div>
                    </div>
                    <div class="space">
                        <Input v-model="data.description" type="textarea" :rows="4" placeholder="Description" />
                    </div> 
                    <div class="space">
                        <vue-editor id="editor" useCustomImageHandler @image-added="handleImageAdded" v-model="data.post"> </vue-editor>
                    </div>       
                    <div class="space">
                        <Select v-model="data.categoryId" filterable multiple placeholder="Select Category">
                            <Option v-for="(category, i) in categories" :key="i" :value="category.id">{{ category.name }}</Option>
                        </Select>
                    </div>
                    <div class="space">
                        <Select v-model="data.tagId" filterable multiple placeholder="Select tag">
                            <Option v-for="(tag, i) in tags" :key="i" :value="tag.id">{{ tag.name }}</Option>
                        </Select>
                    </div>
                    <div class="space">
                        <Input v-model="data.metaDescription" type="textarea" :rows="4" placeholder="Meta Description" />
                    </div> 
                    <div slot="footer">
                        <Button type="default" @click="addModal=false">Close</Button>
                        <Button type="primary" @click="add" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...':'Add Blog'}}</Button>
                    </div>               
                </Modal>
                <!-- Tag edit modal -->
                <Modal
                    v-model="editModal"
                    title="Edit Tag"
                    :mask-closable="false"
                    :closable="false">

                    <div class="space">
                        <Input v-model="editData.title" placeholder="Title"/>
                    </div>
                    <div class="space">
                        <Upload 
                        v-show="isImageUploader"
                        ref="editUploads"
                        type="drag" 
                        action="/app/common/upload" 
                        :on-success="handleSuccess"
                        :on-error="handleError"
                        :format="['jpg','jpeg','png']"
                        :max-size="2048"
                        :on-format-error="handleFormatError"
                        :on-exceeded-size="handleMaxSize"
                        :headers="{ 'x-csrf-token': token }" :data="{ 'folder_path': folder}" >
                        <div style="padding: 20px 0">
                            <Icon type="ios-cloud-upload" size="52" style="color:#3399ff"></Icon>
                            <p>Click or drag files here to upload feature image</p>
                        </div>
                        </Upload>
                        <div class="demo-upload-list" v-if="editData.image">
                            <img :src="`${editData.image}`" />
                            <div class="demo-upload-list-cover">
                            <Icon type="ios-trash-outline" @click="deleteImage(false)"></Icon>
                            </div>
                        </div>
                    </div>
                    <div class="space">
                        <Input v-model="editData.description" type="textarea" :rows="4" placeholder="Description" />
                    </div> 
                    <div class="space">
                        <vue-editor id="editor" useCustomImageHandler @image-added="handleImageAdded" v-model="editData.post"> </vue-editor>
                    </div>       
                    <div class="space">
                        <Select v-model="editData.categoryId" filterable multiple placeholder="Select Category">
                            <Option v-for="(category, i) in categories" :key="i" :value="category.id">{{ category.name }}</Option>
                        </Select>
                    </div>
                    <div class="space">
                        <Select v-model="editData.tagId" filterable multiple placeholder="Select tag">
                            <Option v-for="(tag, i) in tags" :key="i" :value="tag.id">{{ tag.name }}</Option>
                        </Select>
                    </div>
                    <div class="space">
                        <Input v-model="editData.metaDescription" type="textarea" :rows="4" placeholder="Meta Description" />
                    </div> 

                    <div slot="footer">
                        <Button type="default" @click="closeEditModal">Close</Button>
                        <Button type="primary" @click="edit" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing...':'Edit Blog'}}</Button>
                    </div>               
                </Modal>
			</div>
            <deleteModal></deleteModal>
		</div>
    </div>
</template>
<script>
import deleteModal from '../components/deleteModal'
import {mapGetters} from 'vuex'
import { VueEditor } from "vue2-editor";
export default {
    data(){
        return {
            data:{
                title:'',
                post:'',
                description:'',
                metaDescription:'',
                categoryId:[],
                tagId:[],
                image:'',                
            },
            addModal: false,
            isAdding: false,
            editModal: false,            
            editData:{
                title:'',
                post:'',
                description:'',
                metaDescription:'',
                categoryId:[],
                tagId:[],
                image:'',
            },
            index:-1,
            categories: [],
            blogs:[],
            tags:[],
            total:1,
            pageInfo: null,
            folder: '/uploads/blog/',
            isImageUploader: false,
            isEditingImage:false,
        }
    },
    methods: {
        async add(){                        
            if(this.data.title.trim()=='') return this.e('Blog Title is required!')
            if(this.data.post.trim()=='') return this.e('Blog post is required!')
            if(this.data.description.trim()=='') return this.e('Blog description is required!')            
            // if(!this.data.categoryId.length) return this.e('Blog category is required!')                        
            this.isAdding=true
            const res = await this.callApi('post', 'app/blog/create', this.data);
            console.log(res);
            if(res.status == 200) {
                this.s('Blog has been added successfully!')
                this.blogs.unshift(res.data);
                this.addModal = false
                this.isAdding = false
                this.data.name = ''
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
        async edit(){            
            if(this.editData.title.trim()=='') return this.e('Blog Title is required!')
            if(this.editData.post.trim()=='') return this.e('Blog post is required!')      
            if(this.editData.description.trim()=='') return this.e('Blog description is required!')                  
            if(!this.editData.categoryId.length) return this.e('Blog category is required!')    
            this.isAdding=true
            const res = await this.callApi('post', 'app/blog/update', this.editData);
            console.log(res);
            if(res.status == 200) {
                this.s('Blog has been edited successfully!')                
                this.editModal = false
                this.isAdding = false                
                this.blogs[this.index].title = res.data.title
                this.blogs[this.index].post = res.data.post
                this.blogs[this.index].description = res.data.description
                this.blogs[this.index].meta_description = res.data.meta_description                
                this.blogs[this.index].categories = res.data.categories
                this.blogs[this.index].tags = res.data.tags
                this.blogs[this.index].image = res.data.image

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
        async showEditModal(blog,index) {     
            let categoryIds = blog.categories.map(c => c.id);
            let tagIds = blog.tags.map(t => t.id);
            console.log(tagIds)
            let data = {
                id:blog.id,
                title:blog.title,
                post:blog.post,
                description:blog.description,
                metaDescription:blog.meta_description,
                categoryId:categoryIds,
                tagId:tagIds,
                image:blog.image,
            }
            if(!data.image) {
                this.isImageUploader = true
                this.isEditingImage = true
            }
            this.editData = data
            this.editModal = true
            this.index = index
        },
        showDeleteModal(blog, index){
            const deleteModalObj = {
                showDeleteModal: true,
                deleteUrl: 'app/blog/delete/'+blog.id,
                data: blog,
                deletingIndex: index,
                isDeleted: false,
            }
            this.$store.commit('setDeleteModalProperty', deleteModalObj)
        },
        handleImageAdded: async function(file, Editor, cursorLocation, resetUploader) {//editor image handler
            var formData = new FormData();
            formData.append("image", file);

            const res = await this.callApi('post', '/app/common/upload_editor_image',formData);            
            if(res.status == 200) {
                let url = res.data; // Get url from response
                Editor.insertEmbed(cursorLocation, "image", url);
                resetUploader();
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
        async getBlogData(page = 1) {
            console.log(page);
            const blogs = await this.callApi('get', `app/blog?page=${page}&total=${this.total}`)
            if(blogs.status == 200) {
                this.blogs = blogs.data.data
                this.pageInfo = blogs.data                    
            } else {
                this.swr();
            }
        },
        handleSuccess(res, file) {
            res = this.folder+res;            
            if (this.isEditingImage) {
                console.log("inside");
                this.isImageUploader = false
                return (this.editData.image = res);
            }            
            this.data.image = res;
            this.isImageUploader = false
            
        },
        handleError(res, file) {
            console.log('res',res);
            console.log('file',file);
            this.$Notice.warning({
                title: "The file format is incorrect",
                desc: `${
                file.error.length
                    ? file.error
                    : "Something went wrong!"
                }`
            });
        },
        handleFormatError(file) {
            this.$Notice.warning({
                title: "The file format is incorrect",
                desc:
                "File format of " +
                file.name +
                " is incorrect, please select jpg or png."
            });
        },
        handleMaxSize(file) {
            this.$Notice.warning({
                title: "Exceeding file size limit",
                desc: "File  " + file.name + " is too large, no more than 2M."
            });
        },
        async deleteImage(isAdd=true) {
            let file=''
            if(!isAdd) {
                this.isImageUploader = true
                file = this.editData.image
                this.editData.image = ''
                this.$refs.editUploads.clearFiles()
                this.isEditingImage = true
            } else {                
                file = this.data.image
                this.data.image = ''
                this.$refs.uploads.clearFiles()
                const res = await this.callApi('post', '/app/common/delete_file',{ file_path: file });
                if(res.status != 200) {
                    this.data.image = file                
                    //console.log(res)
                }       
            }
        },
        closeEditModal(){
            this.isEditingImage = false
            this.editModal = false
        }
    },
    async created(){        
        this.token = window.Laravel.csrfToken    
        this.total = this.getPerPage
        this.getBlogData();
        const [category, tags] = await Promise.all([
            this.callApi('get', 'app/category'),            
            this.callApi('get', 'app/tag')
        ]);

        if(category.status == 200) {
            this.categories = category.data
        } else {
            this.swr();
        }      
        
        if(tags.status == 200) {
            this.tags = tags.data                   
        } else {
            this.swr();
        }
    },
    components: {
        deleteModal,
        VueEditor
    },
    computed: {
        ...mapGetters(['getDeleteModalObj','getPerPage'])
    },
    watch: {
        getDeleteModalObj(obj) {            
            if(obj.isDeleted) {
                this.blogs.splice(obj.deletingIndex,1)
            }
        }
    }
}
</script>