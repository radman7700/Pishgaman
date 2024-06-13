<template>
    <div class="card col-sm-12" style="margin-top: 12px;padding: 12px;">
        <table class="table">
            <thead>
                <tr>
                    <td class="align-middle">#</td>
                    <td class="align-middle">عنوان</td>
                    <td class="align-middle">تاریخ ایجاد</td>
                    <td class="align-middle">دانلود</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item,index) in downloadList" :style="(item.read == 0) ? 'font-weight: bold;background-color: honeydew;' : 'color:blue'">
                    <td class="align-middle" >{{(index + itemsPerPage * (pagination.current_page - 1)) + 1}}</td>
                    <td class="align-middle">{{item.name}}</td>
                    <td class="align-middle">{{convertDateToPersian(item.created_at)}}</td>
                    <td class="align-middle" title="برای دانلود فایل بر روی دکمه دانلود کلیک کنید">
                        <a v-if="item.status == 100" :href="getAppUrl()+'download?id='+item.id" @click="this.getList(pagination.current_page)" class="btn btn-primary" style="color:#fff"><i class="fa fa-download"></i></a>
                    </td>
                </tr>
            </tbody>        
        </table>
    </div>    
    <div class="card col-sm-12" style="margin-top: 12px;padding: 12px;" v-if="pagination.last_page != 1">
      <nav aria-label="Page navigation">
          <ul class="pagination">
              <li v-if="pagination.current_page > 1">
                  <a href="#" aria-label="Previous" class="page-link" @click.prevent="changePage(pagination.current_page - 1,orderbyValue)">
                      <span aria-hidden="true">&laquo;</span>
                  </a>
              </li>
              <li v-for="page in pagesNumber"
                  :class="[ page == isActived ? 'page-item active' : '']">
                  <a href="#" @click.prevent="changePage(page,orderbyValue)" class="page-link">{{ page }}</a>
              </li>
              <li v-if="pagination.current_page < pagination.last_page">
                  <a href="#" aria-label="Next" class="page-link"
                      @click.prevent="changePage(pagination.current_page + 1,orderbyValue)">
                      <span aria-hidden="true">&raquo;</span>
                  </a>
              </li>
          </ul>
      </nav>
    </div>    
</template>
<script>
import jalaliMoment from "jalali-moment";

export default {
    data() {
        return {
            downloadList:[],
            downloadCount:0,
            pagination: {
                total: 0,
                per_page: 2,
                from: 1,
                to: 0,
                current_page: 1,
                last_page: 1
            },
            offset:4,
            itemsPerPage:10,            
        }
    },
    components: {  },  
    mounted() {
        this.getList();
    },
    methods: {
        convertDateToPersian(date){
            return jalaliMoment(date, "YYYY-MM-DD HH:mm:ss").format("jYYYY/jMM/jDD HH:mm:ss");
        },        
        checkString(yourString) {
            if (yourString.indexOf('telegram_users') !== -1) {
                return yourString.replace("telegram_users_","");
            } else if (yourString.indexOf('telegram_Group_message') !== -1) {
                return yourString.replace("telegram_Group_message_","");
            } else if (yourString.indexOf('telegram_group_users') !== -1) {
                return yourString.replace("telegram_group_users_","");
            }else {
                return yourString;
            }
        },
        getList(page=1){
            axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
                const token = response.data.token;
                axios.request({
                    method: 'GET',
                    url: this.getAppUrl() + 'api/download?action=getList&page='+page,
                    headers: {'Authorization': `Bearer ${token}`}
                }).then(response => {
                    this.fetchPagesDetails(response.data.downloadList);        
                    this.downloadList = response.data.downloadList.data;
                }).catch(error => {
                    this.checkError(error);
                });
            }).catch(error => {
                this.checkError(error);
            });            
        },
        fetchPagesDetails: function (page) {
            this.pagination = {
                total: page['total'],
                per_page: page['per_page'],
                from: page['from'],
                to: page['to'],
                current_page: page['current_page'],
                last_page: page['last_page'],
            };
        },
        changePage: function (page,orderbyValue) {
            this.getList(page,'');
        },         
    },
    computed: {
      isActived () {
        return this.pagination.current_page;
      },
      pagesNumber () {
        if (!this.pagination.to) {
            return [];
        }
        let from = this.pagination.current_page - this.offset;
        if (from < 1) {
            from = 1;
        }
        let to = from + (this.offset * 2);
        if (to >= this.pagination.last_page) {
            to = this.pagination.last_page;
        }
        let pagesArray = [];
        while (from <= to) {
            pagesArray.push(from);
            from++;
        }
        return pagesArray;
      
    }
  }      
}

</script>
