import {mapGetters} from 'vuex'
export default {
    data(){
        return {

        }
    },
    methods: {
        async callApi(method, url, dataObj) {
            try {
                return await axios({
                    method: method,
                    url: url,
                    data: dataObj
                });
            } catch (e) {
                return e.response
            }
        },
        i(desc, title = "Hey") {
            this.$Notice.info({
                title: title,
                desc: desc
            });
        },
        s(desc, title = "Great!") {
            this.$Notice.success({
                title: title,
                desc: desc
            });
        },
        w(desc, title = "Oops!") {
            this.$Notice.warning({
                title: title,
                desc: desc
            });
        },
        e(desc, title = "Oops!") {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        },
        swr(desc= "Something went wrong!Please try again.", title = "Hey") {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        },
        checkPermission(key){
            if(!this.userPermission) return false
            let isPermitted = false
            for(let permission of this.userPermission) {             
                if(permission.permission_route == this.$route.name) {                    
                    if(permission[key]) {
                        isPermitted = true
                        break;
                    } else {
                        break
                    }
                }
            }
            return isPermitted;
        }
    },
    computed: {
        ...mapGetters({
            'userPermission': 'getPermission'
        }),
        isReadyPermitted(){
            return this.checkPermission('read');
        },
        isWritePermitted(){
            console.log(this.checkPermission('write'))
            return this.checkPermission('write');
        },
        isUpdatePermitted(){
            return this.checkPermission('update');
        },
        isDeletePermitted(){
            return this.checkPermission('delete');
        }
    }
}