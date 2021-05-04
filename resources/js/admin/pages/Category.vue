<template>
    <div>
       <div class="content">
			<div class="container-fluid">					
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Category <Button @click="addModal=true" v-if="isWritePermitted"><Icon type="md-add"/>Add Category</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>Id</th>
                                <th>image</th>
								<th>Name</th>								
                                <th>Create At</th>								
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(category, i) in categories" :key="i" >
								<td>{{category.id}}</td>
                                <td class="table_image">
                                    <img :src="category.image" />
                                </td>
                                <td class="_table_name">{{category.name}}</td>								
								<td>{{category.created_at}}</td>	                                
								<td>									
									<Button class="_btn _action_btn edit_btn1" type="info" @click="showEditCategoryModal(category, i)" v-if="isUpdatePermitted">Edit</button>									
									<Button class="_btn _action_btn make_btn1" type="error" @click="showDeleteModal(category,i)" :loading="category.isDeleting" v-if="isDeletePermitted">Delete</button>
								</td>
							</tr>
								<!-- ITEMS -->
						</table>
					</div>
				</div>
				<!-- <Page :total="100" /> -->
                <!-- add modal -->
                <Modal
                    v-model="addModal"
                    title="Add Category"
                    :mask-closable="false"
                    :closable="false">
                    <Input v-model="data.name" placeholder="Add Category Name"/>
                    <div class="space"></div>
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
                            <p>Click or drag files here to upload</p>
                        </div>
                    </Upload>
                    <div class="demo-upload-list" v-if="data.image">
                        <img :src="`${data.image}`" />
                        <div class="demo-upload-list-cover">
                        <Icon type="ios-trash-outline" @click="deleteImage"></Icon>
                        </div>
                    </div>
                    <div slot="footer">
                        <Button type="default" @click="addModal=false">Close</Button>
                        <Button type="primary" @click="addCategory" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...':'Add Category'}}</Button>
                    </div>               
                </Modal>
                <!-- edit modal -->
                <Modal
                    v-model="editModal"
                    title="Edit Category"
                    :mask-closable="false"
                    :closable="false">

                    <Input v-model="editData.name" placeholder="Edit Category Name"/>
                    <div class="space"></div>
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
                            <p>Click or drag files here to upload</p>
                        </div>
                    </Upload>
                    <div class="demo-upload-list" v-if="editData.image">
                        <img :src="`${editData.image}`" />
                        <div class="demo-upload-list-cover">
                        <Icon type="ios-trash-outline" @click="deleteImage(false)"></Icon>
                        </div>
                    </div>
                    <div slot="footer">
                        <Button type="default" @click="closeEditModal">Close</Button>
                        <Button type="primary" @click="editCategory" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing...':'Edit Category'}}</Button>
                    </div>               
                </Modal>
                <deleteModal></deleteModal>
			</div>
		</div>
    </div>
</template>
<script>
import deleteModal from '../components/deleteModal'
import {mapGetters} from 'vuex'
export default {
    data(){
        return {
            data:{
                name:'',
                image:'',
            },
            addModal: false,
            isAdding: false,
            editModal: false,            
            editData:{
                name:'',
                image:'',
            },
            index:-1,
            token:'',
            categories: [],
            isImageUploader: false,
            isEditingImage:false,
            folder: '/uploads/category/'
        }
    },
    methods: {
        async addCategory(){            
            if(this.data.name.trim()=='') return this.e('Category name is required!')
            if(this.data.image.trim()=='') return this.e('Category image is required!')
            this.isAdding=true
            const res = await this.callApi('post', 'app/category/create', this.data);
            console.log(res);
            if(res.status == 201) {
                this.s('Category has been added successfully!')
                this.categories.unshift(res.data);
                this.addModal = false
                this.isAdding = false
                this.data.name = ''
                this.data.image = ''
                this.$refs.uploads.clearFiles()
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
        async editCategory(){                        
            if(this.editData.name.trim()=='') return this.e('Category name is required!')
            if(this.editData.image.trim()=='') return this.e('Category image is required!')
            this.isAdding=true
            const res = await this.callApi('post', 'app/category/update', this.editData);
            console.log(res);
            if(res.status == 200) {
                this.s('Category has been edited successfully!')                
                this.editModal = false
                this.isAdding = false                
                this.categories[this.index].name = res.data.name
                this.categories[this.index].image = res.data.image
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
        async showEditCategoryModal(category,index) {
            let categoryData = {
                id:category.id,
                name:category.name,
                image:category.image,
            }
            this.editData = categoryData
            this.editModal = true
            this.index = index
        },
        showDeleteModal(category, index){
            const deleteModalObj = {
                showDeleteModal: true,
                deleteUrl: 'app/category/delete/'+category.id,
                data: category,
                deletingIndex: index,
                isDeleted: false,
            }
            this.$store.commit('setDeleteModalProperty',deleteModalObj)
            console.log(deleteModalObj);
        },
        handleSuccess(res, file) {
            res = this.folder+res;
            if (this.isEditingImage) {
                console.log("inside");
                return (this.editData.image = res);
            }
            console.log(res);
            this.data.image = res;
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
        const res = await this.callApi('get', 'app/category');
        console.log(res);
        if(res.status == 200) {
            this.categories = res.data
            //console.log(res)
        } else {

        }
    },
    components: {//load components
        deleteModal
    },
    computed: {
        //use to get value from vuex
        ...mapGetters(['getDeleteModalObj'])
    },
    watch: { //call after value change
        getDeleteModalObj(obj) {            
            if(obj.isDeleted) {
                this.categories.splice(obj.deletingIndex,1)
            }
        }
    }
}
</script>