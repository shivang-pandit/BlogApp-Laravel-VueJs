<template>
    <div>
       <div class="content">
			<div class="container-fluid">
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Recent inquiry</p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>Date</th>
								<th>name</th>
                <th>email</th>
								<th>Description</th>
							</tr>
								<!-- TABLE TITLE -->
								<!-- ITEMS -->
							<tr v-for="(inquiry, i) in inquiries" :key="i" >
								<td>25-05-19</td>
                <td>{{ inquiry.name }}</td>
                <td class="_table_name">{{ inquiry.email }}</td>
								<td>{{ inquiry.message }}</td>
							</tr>
								<!-- ITEMS -->
						</table>
					</div>
				</div>
        <Page :total="pageInfo.total" :current="pageInfo.current_page" :page-size="parseInt(pageInfo.per_page)" @on-change="getData" v-if="pageInfo" />
      </div>
		</div>
    </div>
</template>
<script>
import { mapGetters } from 'vuex'
export default {
  data(){
    return {
      data:{
        name:''
      },
      inquiries: [],
      pageInfo: null,
      total:1,
    }
  },
  methods: {
    async getData(page = 1) {
      console.log(page);
      const inquiries = await this.callApi('get', `admin/app/admin/inquiries?page=${page}&total=${this.total}`)
      if(inquiries.status == 200) {
        this.inquiries = inquiries.data.data
        this.pageInfo = inquiries.data
      } else {
        this.swr();
      }
    },
  },
  async created(){
    console.log(this.isReadyPermitted)
    this.total = this.getPerPage
    this.getData();
  },
  computed: {
    ...mapGetters(['getPerPage'])
  },
  watch: {
    getDeleteModalObj(obj) {
      if(obj.isDeleted) {
        this.inquiries.splice(obj.deletingIndex,1)
      }
    }
  }
}
</script>