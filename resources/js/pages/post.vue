<template>
    <div class="container">
        <div class="container p-5">
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Add Post
</button>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger" id="exampleModalLabel">Create Post</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form  @submit.prevent="poststore">
          <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" v-model="form.title" id="title" aria-describedby="title">
          </div>
          <div class="mb-3">
            <label for="Description" class="form-label">Description</label>
            <textarea
              id="e-textarea"
              class="form-control"
              row="3"
             v-model="form.description"
            >
            </textarea>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</div>
        <table id="example" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <!--<th>Actions</th>-->
                                </tr>
                            </thead>
                            <tbody v-if="posts.length > 0">
                                <tr v-for="(post,key) in posts" :key="key">
                                    <td>{{ post.id }}</td>
                                    <td>{{ post.title }}</td>
                                    <td>{{ post.description }}</td>
                                   <!-- <td>
                                        <router-link :to='{name:"postEdit",params:{id:post.id}}' class="btn btn-success">Edit</router-link>
                                        <button type="button" @click="deletePost(post.id)" class="btn btn-danger">Delete</button>
                                    </td>-->
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="4" align="center">No Posts Found.</td>
                                </tr>
                            </tbody>
                        </table>
    </div>
</template>

<script>
    import "bootstrap/dist/css/bootstrap.min.css";
    import "bootstrap/dist/js/bootstrap.min.js";
    import { reactive,ref } from 'vue'
    import { useRouter } from "vue-router"
    import { useStore } from 'vuex'
    export default{
    name:"posts",
    data(){
        return {
            posts:[]
        }
    },
    mounted(){
        this.getPosts()
        //$('#example').DataTable();
    },
    methods:{
        async getPosts(){
            await axios.get('/api/post').then(response=>{
                //console.log(response.data);
                this.posts = response.data
            }).catch(error=>{
                alert('hhhh');
                console.log(error)
                this.posts = []
            })
        },
        deletePost(id){
            if(confirm("Are you sure to delete this post ?")){
                this.axios.delete(`/api/post/${id}`).then(response=>{
                    this.getPosts()
                }).catch(error=>{
                    console.log(error)
                })
            }
        }
    },
        setup(){
            const router = useRouter();
            const store = useStore();
            let form = reactive({
                title :'',
                description: '',
            });
            let errors = ref([])
            function logout(){
                store.dispatch('removeToken');
                router.push({name:'Home'})
            }
            const poststore = async() =>{
                await axios.post('/api/post',form).then(res=>{
                    var x = document.getElementById("exampleModal");
                        x.style.display = "none";
                        this.getPosts();
                }).catch(e=>{
                    errors.value = e.response.data.message
                })
            }
            return {
                logout,
                form,
                errors,
                poststore
            }
        },
       
    }
</script>
