<template>
  <div class="row justify-content-md-center">
    <div class="card col-sm-12">
      <date-picker v-model="date"></date-picker>
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
      date: '',
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
    };
  },
  components: {
  },  
  mounted() {
  },  
  methods: {
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
      this.getUsers(page,'');
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
