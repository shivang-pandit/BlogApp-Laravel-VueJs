<template>
    <div>
       <div class="content">
			<div class="container-fluid">					
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Tags <Button @click="addModal=true" v-if="isWritePermitted"><Icon type="md-add" />Add Tag</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>Id</th>
								<th>Name</th>								
                                <th>Create At</th>								
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(tag, i) in tags" :key="i" >
								<td>{{tag.id}}</td>
                                <td class="_table_name">{{tag.name}}</td>								
								<td>{{tag.created_at}}</td>	                                
								<td>									
									<Button class="_btn _action_btn edit_btn1" type="info" @click="showEditTagModal(tag, i)" v-if="isUpdatePermitted">Edit</button>									
									<Button class="_btn _action_btn make_btn1" type="error" @click="showDeleteModal(tag,i)" :loading="tag.isDeleting" v-if="isDeletePermitted">Delete</button>
								</td>
							</tr>
								<!-- ITEMS -->
						</table>
					</div>
				</div>
				<!-- <Page :total="100" /> -->
                <!-- Tag add modal -->
                <Modal
                    v-model="addModal"
                    title="Add Tag"
                    :mask-closable="false"
                    :closable="false">

                    <Input v-model="data.name" placeholder="Add Tag Name"/>

                    <div slot="footer">
                        <Button type="default" @click="addModal=false">Close</Button>
                        <Button type="primary" @click="addTag" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...':'Add Tag'}}</Button>
                    </div>               
                </Modal>
                <!-- Tag edit modal -->
                <Modal
                    v-model="editModal"
                    title="Edit Tag"
                    :mask-closable="false"
                    :closable="false">

                    <Input v-model="editData.name" placeholder="Edit Tag Name"/>

                    <div slot="footer">
                        <Button type="default" @click="editModal=false">Close</Button>
                        <Button type="primary" @click="editTag" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing...':'Edit Tag'}}</Button>
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
export default {
    data(){
        return {
            data:{
                name:''
            },
            addModal: false,
            isAdding: false,
            editModal: false,            
            editData:{
                name:''
            },
            index:-1,
            tags: []
        }
    },
    methods: {
        async addTag(){            
            if(this.data.name.trim()=='') return this.e('Tag name is required!')
            this.isAdding=true
            const res = await this.callApi('post', 'app/tag/create', this.data);
            console.log(res);
            if(res.status == 201) {
                this.s('Tag has been added successfully!')
                this.tags.unshift(res.data);
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
        async editTag(){            
            if(this.editData.name.trim()=='') return this.e('Tag name is required!')
            this.isAdding=true
            const res = await this.callApi('post', 'app/tag/update', this.editData);
            console.log(res);
            if(res.status == 200) {
                this.s('Tag has been edited successfully!')                
                this.editModal = false
                this.isAdding = false                
                this.tags[this.index].name = res.data.name
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
        async showEditTagModal(tag,index) {
            let tagData = {
                id:tag.id,
                name:tag.name
            }
            this.editData = tagData
            this.editModal = true
            this.index = index
        },
        showDeleteModal(tag, index){
            const deleteModalObj = {
                showDeleteModal: true,
                deleteUrl: 'app/tag/delete/'+tag.id,
                data: tag,
                deletingIndex: index,
                isDeleted: false,
            }
            this.$store.commit('setDeleteModalProperty', deleteModalObj)
        }
    },
    async created(){
        console.log(this.isReadyPermitted)
        const res = await this.callApi('get', 'app/tag');
        console.log(res);
        if(res.status == 200) {
            this.tags = res.data            
        } else {

        }
    },
    components: {
        deleteModal
    },
    computed: {
        ...mapGetters(['getDeleteModalObj'])
    },
    watch: {
        getDeleteModalObj(obj) {            
            if(obj.isDeleted) {
                this.tags.splice(obj.deletingIndex,1)
            }
        }
    }
}
</script>