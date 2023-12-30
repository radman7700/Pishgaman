<template>
    <a href="#" class="nav-link" data-toggle="dropdown" @click="getList()">
        <i class="ti-bell"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right dropdown-menu-big" >
        <div class="p-4 text-center" data-backround-image="assets/media/image/image1.png">
            <h6 class="m-b-0">اعلان ها</h6>
            <small class="font-size-13 opacity-7">2 اعلان خوانده نشده</small>
        </div>
        <div class="p-3">
            <div class="timeline">
                <div class="timeline-item" v-for="item in downloadList">
                    <div>
                        <figure class="avatar avatar-state-danger avatar-sm m-r-15 bring-forward">
                            <span class="avatar-title bg-info-bright text-info rounded-circle">
                                <i class="fa fa-download font-size-20"></i>
                            </span>
                        </figure>
                    </div>
                    <div>
                        <p class="m-b-5">
                            <a :href="getAppUrl()+'media/download/'+item.file_path" target="_blank" v-if="item.status == 100">{{ checkString(item.name) }} </a>
                            <b v-else>
                                <span class="spinner-grow spinner-grow-sm m-r-5" role="status" aria-hidden="true"></span>
                                در حال پردازش ...
                            </b>                            
                        </p>
                        <small class="text-muted">
                            <i class="fa fa-clock-o m-r-5"></i> {{convertDateToPersian(item.created_at)}} 
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-3 text-right">
            <ul class="list-inline small">
                <li class="list-inline-item">
                    <a href="#">علامت خوانده شده به همه</a>
                </li>
            </ul>
        </div>
    </div>    
</template>

<script>
import jalaliMoment from "jalali-moment";

export default {
    data() {
        return {
            downloadList:[],
            downloadCount:0
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
        getList(){
            axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
                const token = response.data.token;
                axios.request({
                    method: 'GET',
                    url: this.getAppUrl() + 'api/download?action=getList',
                    headers: {'Authorization': `Bearer ${token}`}
                }).then(response => {
                    this.downloadList = response.data.downloadList; 
                    this.downloadCount = response.data.downloadCount; 
                }).catch(error => {
                    this.checkError(error);
                });
            }).catch(error => {
                this.checkError(error);
            });            
        }
    }    
}

</script>
