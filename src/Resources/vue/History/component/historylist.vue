<template>
    <div class="row justify-content-md-center">
        <div class="card col-sm-12">
            <div class="card-body text-left">
                <div class="form-row row">
                    <div class="col-md-4 mb-3">   
                        <input type="text" class="form-control" id="searchQuery" v-model="searchQuery" placeholder="جستجو " autocomplete="off">  
                    </div>
                    <div class="col-md-2 mb-2">
                        <select class="form-control" id="itemsPerPage" v-model="itemsPerPage">
                        <option value="5">5 مورد در صفحه</option>
                        <option value="10">10 مورد در صفحه</option>
                        <option value="20">20 مورد در صفحه</option>
                        <option value="30">30 مورد در صفحه</option>
                        <option value="40">40 مورد در صفحه</option>
                        <option value="50">50 مورد در صفحه</option>
                        <option value="100">100 مورد در صفحه</option>
                        <option value="0">نمایش همه سطوح دسترسی</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-2">
                        <button class="btn btn-info btn-block" @click="getUsers"><i class="fa fa-search"></i> اعمال فیلترها</button>
                    </div>          
                </div>          
            </div>            
        </div>
        <div class="card col-md-12" style="margin-top: 12px;padding: 12px;">
            <table class="table table-bordered mt-4">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <!-- <th scope="col">تصویر کاربر</th> -->
                    <th scope="col">کاربر</th>
                    <th scope="col">تاریخ</th>
                    <th scope="col">برنامه</th>
                    <th scope="col">IP</th>
                    <th scope="col">وضعیت اجرا</th>
                    <th scope="col">وضعیت دسترسی</th>
                </tr>
                </thead>
                <tbody v-for="(history, index) in histories">
                    <tr>
                        <td>{{(index + itemsPerPage * (pagination.current_page - 1)) + 1}}</td>
                        <!-- <td>
                            <img :src="userImage(history.user.id )" onerror="this.src='http://localhost/example-app/public/media/images/Users/Profile/noImage.png'" alt="تصویر پروفایل کاربر" width="115" height="115">
                        </td> -->
                        <td><b>{{ history.user.username  }}</b><br>{{ history.user.name }} {{ history.user.last_name }}<br>{{ history.user.email  }}</td>
                        <td>{{convertDate(history.created_at,'jYYYY/jM/jD HH:mm:ss')}}</td>
                        <td>{{translateText(history.message.split('_')[0])}}</td>
                        <td>{{ history.ip }}</td>
                        <td>{{ history.executed ? 'بله' : 'خیر' }}</td>
                        <td>{{ history.is_accessible ? 'بله' : 'خیر' }}</td>
                    </tr>
                    <tr>
                        <td colspan="8">شرح: {{translateText(history.message)}} <p v-html="history.description"></p></td>
                    </tr>                
                </tbody>
            </table>
        </div>
        <div class="card col-sm-12" v-if="pagination.last_page != 1" style="margin-top: 12px;padding: 12px;">
            <nav aria-label="Page navigation" >
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
    </div>
</template>

<script>
import Swal from 'sweetalert2';

export default {
    data() {
        return {
            itemsPerPage:20,  
            histories:[],

            pagination: {
                total: 0,
                per_page: 2,
                from: 1,
                to: 0,
                current_page: 1,
                last_page: 1
            },
            offset:4,
            itemsPerPage:20,   
            searchQuery:'',            
        }
    },
    mounted() {
        this.getHistoies();
    },  
    methods: { 
        userImage(userId) {
            var randomNum = Math.floor(Math.random() * 100) + 1;
            const baseUrl = this.getAppUrl();
            return `${baseUrl}media/images/Users/Profile/${userId}.png?timestamp=${randomNum}`
        },    
        getHistoies(page = 1,first=1) {   
            axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
                const token = response.data.token;
                axios.request({
                    method: 'GET',
                    url: this.getAppUrl() + 'api/admin/history?action=getHistoies&itemsPerPage='+this.itemsPerPage+'&searchQuery='+this.searchQuery+'&page='+page,
                    headers: {'Authorization': `Bearer ${token}`}
                }).then(response => {
                    this.fetchPagesDetails(response.data);        
                    this.histories = response.data.data;
                    this.searchQuery='';
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
            this.getHistoies(page,'');
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