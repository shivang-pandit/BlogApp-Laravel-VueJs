<template>
    <div>
        <Modal :value="getDeleteModalObj.showDeleteModal" width="360" :mask-closable="false"
                    :closable="false">
            <p slot="header" style="color:#f60;text-align:center">
                <Icon type="ios-information-circle"></Icon>
                <span>Delete Information</span>
            </p>
            <div style="text-align:center;">
                <p>Are you sure you want to delete?</p>
            </div>
            <div slot="footer">
                <Button type="default" size="large" @click="closeModal">Close</Button>
                <Button type="error" size="large" @click="deleteAttribute" :disabled="isDeleting" :loading="isDeleting">Delete</Button>
            </div>               
        </Modal>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
export default {
    data(){
        return {
            isDeleting: false
        }
    },
    methods:{
        async deleteAttribute() {           
            this.isDeleting = true 
            console.log("delete modal call",this.getDeleteModalObj.deleteUrl)                   
            const res = await this.callApi('delete', this.getDeleteModalObj.deleteUrl)
            console.log(res);
            if(res.status == 200) {
                console.log(res)
                this.s(res.data.msg)                                
                this.$store.commit('setDeleteModal',true)
                this.isDeleting = false
            } else if(res.status == 422){
                if(res.data.error){
                    this.e(res.data.error)
                    this.$store.commit('setDeleteModal',false)
                    this.isDeleting = false
                }                
            } else {
                this.swr()
                this.$store.commit('setDeleteModal',false)
                this.isDeleting = false
            }            
        },
        closeModal(){
            this.$store.commit('closeModal')
        }
    },
    computed: {
        ...mapGetters(['getDeleteModalObj'])
    }
}
</script>