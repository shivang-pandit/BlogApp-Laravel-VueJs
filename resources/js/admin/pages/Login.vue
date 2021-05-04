<template>
    <div>
       <div class="container">							
            <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20 col-md-4">
                <div class="login_header">
                    <h1>Login to the dashboard</h1>
                </div>
                <div class="space">
                    <Input type="email" v-model="data.email" placeholder="Email"/>
                </div>
                <div class="space">
                    <Input type="password" v-model="data.password" placeholder="Password"/>
                </div>
                <div class="login_footer">
                    <Button type="primary" @click="login" :disabled="isLogging" :loading="isLogging">{{ isLogging? 'Logging...':'login' }} </Button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            data: {
                email:'',
                password:'',
            },
            isLogging: false,
        }
    },
    methods: {
        async login(){
            if(this.data.email.trim() == '') return this.e('Email is required!')
            if(this.data.password.trim() == '') return this.e('Password is required!')
            if(this.data.password.length < 6) return this.e('Incorrect login details!')
            const res = await this.callApi('post', 'app/admin/login', this.data)
            if(res.status === 200) {   
               this.s(res.data.msg);
               this.isLogging = true
               window.location = '/admin';
            } else if(res.status === 422){
               this.isLogging = false
               if(res.data.error){
                    this.e(res.data.error);
                }
            } else {
                this.swr()               
            }
        }
    }
}
</script>
<style scoped>
._1adminOverveiw_table_recent {
    margin: 0 auto;
    margin-top: 220px;
    text-align: center;
}
</style>