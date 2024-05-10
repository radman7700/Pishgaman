<template>
  <div class="row justify-content-md-center">
    <div class="card col-sm-12">
      <div class="card-body text-left">
        <div class="form-row row">
          <div class="col-md-2 mb-2">      
            <button class="btn btn-primary" @click="showModal"><i class="fa fa-plus"></i> ایجاد سطح دسترسی</button>
          </div>
          <div class="col-md-4 mb-3">   
            <input type="text" class="form-control" id="searchQuery" v-model="searchQuery" placeholder="جستجو سطح دسترسی">
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
            <button class="btn btn-info btn-block" @click="getAccessLevel"><i class="fa fa-search"></i> اعمال فیلترها</button>
          </div>          
        </div>          
      </div>
    </div>

    <div class="card col-sm-12" style="margin-top: 12px;padding: 12px;">
      <table class="table table-bordered mt-4">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">نام سطح دسترسی</th>
            <th scope="col">عملیات</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(permission, index) in permissions" :key="index">
            <td class="align-middle">{{(index + itemsPerPage * (pagination.current_page - 1)) + 1}}</td>
            <td>{{ permission.name }}</td>
            <td>
              <button class="btn btn-success  btn-icon" @click="showEditModal(index)" title="ویرایش">
                <i class="fa fa-edit"></i>
              </button>            
              <button class="btn btn-danger btn-icon" @click="deletePermission(permission.id)" title="حذف">
                <i class="fa fa-trash"></i>
              </button>
              <button class="btn btn-info btn-icon" @click="getMenus(permission.id)" data-bs-toggle="modal" data-toggle="modal" data-bs-target="#myModal" data-target="#myModal">
                <i class="fa fa-lock"></i>
              </button>              
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="card col-sm-12" style="margin-top: 12px;padding: 12px;">
        <nav aria-label="Page navigation" v-if="pagination.last_page != 1">
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
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">فهرست منوها</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-4" v-for="item in menus">
                <div class="form-check form-switch text-left">
                  <input class="form-check-input" type="checkbox" :id="'flexSwitchCheckDefault_'+item.id" :checked="checked(item.id)" @change="checkboxMenuChanged(item.id)">
                  <label class="form-check-label" for="flexSwitchCheckDefault" style="padding-right:20px"><b>{{translateText(item.name)}}</b></label>
                </div>                               
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>  
  </div>
</template>

<style>
.editable {
  cursor: pointer;
}
</style>

<script>
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      AccessLevelMenuId: {},
      AccessLevelIdSelected:'',
      permissions: {},
      menus:{},
      editingIndex: -1,
      mouseIsOver: false,
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
      modalOpen: false  
    };
  },
  mounted() {
    this.getAccessLevel();
  },  
  methods: {
    checkboxMenuChanged(menuId)
    {
      axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
        const token = response.data.token;
        const accessLevelName = name;
        const action = 'updateAccessLevelMenu';
        const accessLevelId = this.AccessLevelIdSelected;
        axios.request({
          method: 'put',
          url: this.getAppUrl() + 'api/admin/AccessLevel',
          headers: {'Authorization': `Bearer ${token}`},
          data: { 'accessLevelName':accessLevelName, 'action': action, 'accessLevelId':accessLevelId,'menuId':menuId}
        }).then(response => {
        }).catch(error => {
          this.checkError(error);
        });        
      }).catch(error => {
          this.checkError(error);
      });
    },
    checked(menuId)
    {
      return this.AccessLevelMenuId.some(item => item.menu_id === menuId)
      if(this.AccessLevelMenuId.some(item => item.menu_id === menuId))  
        return 'checked';
      else
        return '';
    },
    getMenus(accessLevelId)
    {
      this.AccessLevelIdSelected = accessLevelId
      axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
        const token = response.data.token;
        axios.request({
          method: 'GET',
          url: this.getAppUrl() + 'api/admin/AccessLevel?action=getAccessLevelMenus&accessLevelId='+accessLevelId,
          headers: {'Authorization': `Bearer ${token}`}
        }).then(response => {
          this.menus = response.data.menu;
          this.AccessLevelMenuId = response.data.AccessLevelMenu;
        }).catch(error => {
          this.checkError(error);
        });
      }).catch(error => {
          this.checkError(error);
      });    
    },
    async showModal() {
      const { value: name } = await Swal.fire({
        title: this.translateText('createAccessLevel'),
        input: 'text',
        inputPlaceholder: this.translateText('accessLevelName'),
        showCancelButton: true,
        confirmButtonText: this.translateText('submit'),
        cancelButtonText: this.translateText('cancel')
      });

      if (name) {
        this.submitAccessLevel(name);
      }
    }, 
    showEditModal(index) {
      const permission = this.permissions[index];

      Swal.fire({
        title: 'ویرایش سطح دسترسی',
        input: 'text',
        inputValue: permission.name,
        showCancelButton: true,
        confirmButtonText: 'ذخیره تغییرات',
        cancelButtonText: 'لغو',
        preConfirm: (editedName) => {
          this.saveEditedPermission(editedName, permission.id);
        }
      });
    },     
    getAccessLevel(page = 1,first=1) {   
      axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
        const token = response.data.token;
        axios.request({
          method: 'GET',
          url: this.getAppUrl() + 'api/admin/AccessLevel?action=getAccessLevel&itemsPerPage='+this.itemsPerPage+'&searchQuery='+this.searchQuery+'&page='+page,
          headers: {'Authorization': `Bearer ${token}`}
        }).then(response => {
          this.fetchPagesDetails(response.data);        
          this.permissions = response.data.data;
        }).catch(error => {
          this.checkError(error);
        });
      }).catch(error => {
          this.checkError(error);
      });
    },   
    submitAccessLevel(index) {
      axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
        const token = response.data.token;
        const accessLevelName = index;
        const action = 'createAccessLevel';

        axios.request({
          method: 'POST',
          url: this.getAppUrl() + 'api/admin/AccessLevel',
          headers: {'Authorization': `Bearer ${token}`},
          data: { accessLevelName , action }
        }).then(response => {
          this.getAccessLevel();
          Swal.fire(
            'اضافه شد!',
            'سطح دسترسی با موفقیت اضافه شد.',
            'success'
          );          
        }).catch(error => {
          this.checkError(error);
        });        
      }).catch(error => {
          this.checkError(error);
      });
    },     
    editPersubmitAccessLevelmission(index) {

    },    
    editPermission(index) {
      this.editingIndex = index;
    },
    saveEditedPermission(name,id) {
      axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
        const token = response.data.token;
        const accessLevelName = name;
        const action = 'updateAccessLevel';
        const accessLevelId = id;
        axios.request({
          method: 'put',
          url: this.getAppUrl() + 'api/admin/AccessLevel',
          headers: {'Authorization': `Bearer ${token}`},
          data: { 'accessLevelName':accessLevelName, 'action': action, 'accessLevelId':accessLevelId}
        }).then(response => {
          this.getAccessLevel();
          Swal.fire(
            'ویرایش شد!',
            'سطح دسترسی با موفقیت ویرایش شد.',
            'success'
          );          
        }).catch(error => {
          this.checkError(error);
        });        
      }).catch(error => {
          this.checkError(error);
      });
    },
    submitDeletePermission(id){
      axios.get(this.getAppUrl() + 'sanctum/getToken').then(response => {
        const token = response.data.token;
        const action = 'deleteAccessLevel';
        const accessLevelId = id;
        axios.request({
          method: 'delete',
          url: this.getAppUrl() + 'api/admin/AccessLevel',
          headers: {'Authorization': `Bearer ${token}`},
          data: { 'action': action, 'accessLevelId':accessLevelId}
        }).then(response => {
          this.getAccessLevel();
          Swal.fire(
            'حذف شد!',
            'سطح دسترسی با موفقیت حذف شد.',
            'success'
          );           
        }).catch(error => {
          this.checkError(error);
        });        
      }).catch(error => {
          this.checkError(error);
      });       
    },
    deletePermission(index) {
      Swal.fire({
        title: 'آیا اطمینان دارید؟',
        text: "این سطح دسترسی حذف خواهد شد!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'بله، حذف کن!',
        cancelButtonText: 'لغو'
      }).then((result) => {
        if (result.isConfirmed) {
          this.submitDeletePermission(index);
        }
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
      this.getAccessLevel(page,'');
      //this.getAccessLevel(page,1,orderbyValue);
    },    
    setMouseToEdit() {
      if (!this.editingIndex) {
        this.mouseIsOver = true;
      }
    },
    resetMouse() {
      if (!this.editingIndex) {
        this.mouseIsOver = false;
      }
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
};
</script>
