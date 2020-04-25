<template>
    <div class="container">
        <div class="row">
            <div class="col-2">
                <a class="navbar-brand" href="#">Мои задачи</a><i class="fa fa-star-o"></i>
            </div>
            <div class="col-7">
                <input type="text" class="form-control" placeholder="Search" v-on:click="poisk()">
            </div>
            <div class="col-3 float-right">
                <button class="btn btn-secondary"><i class="fa fa-cog"></i></button>
                <button class="btn btn-secondary"><i class="fa fa-bolt"></i></button>
                <button class="btn btn-primary">Добавить</button>
            </div>
        </div>
        <h3 class="mt-5">Задачи</h3>
        <table class="table table-striped">
            <thead>
            <th>ID</th>
            <th>Место работы</th>
            </thead>
            <tbody>
            <tr v-for="(task, index) in tasks" :key=task.id>
                <td>{{ task.id }}</td>
                <td>{{ task.name }}</td>
            </tr>
            </tbody>
        </table>

        <div class="pagination">
            <button class="btn btn-default" v-on:click="fetchPaginateTasks(pagination.prev_page_url)" :disabled="!pagination.prev_page_url">
                Previos
            </button>
            <span>Page {{ pagination.current_page }} of {{ pagination.last_page }} </span>
            <button class="btn btn-default" v-on:click="fetchPaginateTasks(pagination.next_page_url)" :disabled="!pagination.next_page_url">
                Next
            </button>
        </div>

        <!-- добавил стиль z-index: 9998;, шапка закрывал модальное окно -->
        <modal name="search_modal" height="auto" :scrollable="true" style="z-index: 9998;" >

            <div class="my-3 p-3 bg-white rounded box-shadow" style="margin: 15px;">

                <form>

                    <div class="form-group">
                        <label>Роль</label>
                        <v-select multiple label="name" :filterable="false" :options="options.roles" @search="onSearchRole" v-model="selected.roles">
                            <template slot="no-options">
                                введите для поиска по Ролям
                            </template>
                            <template slot="option" slot-scope="option">
                                <div class="d-center">
                                    {{ option.name }}
                                </div>
                            </template>
                            <template slot="selected-option" slot-scope="option">
                                <div class="selected d-center">
                                    {{ option.name }}
                                </div>
                            </template>
                        </v-select>
                    </div>
                    <div class="form-group">
                        <label>Ответственный</label>
                        <v-select multiple label="name" :filterable="false" :options="options.responsible" @search="onSearchResponsible" v-model="selected.responsible">
                            <template slot="no-options">
                                введите для поиска по Постановщику
                            </template>
                            <template slot="option" slot-scope="option">
                                <div class="d-center">
                                    {{ option.name }}
                                </div>
                            </template>
                            <template slot="selected-option" slot-scope="option">
                                <div class="selected d-center">
                                    {{ option.name }}
                                </div>
                            </template>
                        </v-select>
                    </div>
                    <div class="form-group">
                        <label>Постановщик</label>
                        <v-select multiple label="name" :filterable="false" :options="options.directors" @search="onSearchDirector" v-model="selected.directors">
                            <template slot="no-options">
                                введите для поиска по Постановщику
                            </template>
                            <template slot="option" slot-scope="option">
                                <div class="d-center">
                                    {{ option.name }}
                                </div>
                            </template>
                            <template slot="selected-option" slot-scope="option">
                                <div class="selected d-center">
                                    {{ option.name }}
                                </div>
                            </template>
                        </v-select>
                    </div>
                    <div class="form-group">
                        <label for="name">Название</label>
                        <input type="text" class="form-control" id="name" v-model="selected.name">
                    </div>
                    <div class="form-group">
                        <label>Статус</label>
                        <v-select multiple label="name" :filterable="false" :options="options.statuses" @search="onSearchStatus" v-model="selected.statuses">
                            <template slot="no-options">
                                введите для поиска по Статусу
                            </template>
                            <template slot="option" slot-scope="option">
                                <div class="d-center">
                                    {{ option.name }}
                                </div>
                            </template>
                            <template slot="selected-option" slot-scope="option">
                                <div class="selected d-center">
                                    {{ option.name }}
                                </div>
                            </template>
                        </v-select>
                    </div>
                    <div class="form-group">
                        <label>Крайний срок</label>
                        <datetime type="date" input-class="form-control" zone='local' value-zone="local" v-model="selected.date_end" ></datetime>
                    </div>

                </form>
                <button type="submit" class="btn btn-primary" v-on:click="onSearch()">НАЙТИ</button>
                <button type="submit" class="btn btn-secondary" v-on:click="onDiscard()">СБРОСИТЬ</button>

            </div>

        </modal>
    </div>

</template>

<script>
    import VModal from 'vue-js-modal'
    Vue.use(VModal)

    import Vue from 'vue'
    import vSelect from 'vue-select'
    Vue.component('v-select', vSelect)
    import 'vue-select/dist/vue-select.css';

    import Datetime from 'vue-datetime'
    import 'vue-datetime/dist/vue-datetime.css'
    Vue.use(Datetime)

    export default {
        data(){
            return {
                tasks: [],
                url: '/tasks',
                pagination: [],
                listHouses: [],
                options: {
                    statuses: [],
                    directors: [],
                    responsible: [],
                    roles: []
                },
                selected: {
                    statuses: [],
                    directors: [],
                    responsible: [],
                    roles: [],
                    date_end: null,
                    name: ''
                }
            }
        },
        mounted(){
            this.getTasks()
        },
        methods: {
            getTasks(){
                // let $this = this
                axios.post(this.url).then(response => {
                    this.tasks = response.data.data
                    // console.log(response.data)
                    this.makePagination(response.data)
                })
            },
            makePagination(data) {
                let pagination = {
                    current_page: data.current_page,
                    last_page: data.last_page,
                    next_page_url: data.next_page_url,
                    prev_page_url: data.prev_page_url,
                }
                this.pagination = pagination
            },
            fetchPaginateTasks(url) {
                this.url = url
                this.getTasks()
            },
            poisk(){
                this.$modal.show('search_modal');
            },
            onSearch(){
                axios.post('/tasks', {
                    selected: this.selected,
                }).then(response => {
                    this.tasks = response.data.data
                    this.makePagination(response.data)
                    this.$modal.hide('search_modal');
                });
            },
            onDiscard(){
                this.selected.statuses = []
                this.selected.directors = []
                this.selected.responsible = []
                this.selected.roles = []
                this.selected.date_end = null
                this.selected.name = null
            },
            onSearchDirector(search, loading) {
                loading(true);
                let opt = 'directors'
                this.search(loading, search, opt, this);
            },
            onSearchStatus(search, loading) {
                loading(true);
                let opt = 'statuses'
                this.search(loading, search, opt, this);
            },
            onSearchResponsible(search, loading) {
                loading(true);
                let opt = 'responsible'
                this.search(loading, search, opt, this);
            },
            onSearchRole(search, loading) {
                loading(true);
                let opt = 'roles'
                this.search(loading, search, opt, this);
            },
            search: _.debounce((loading, search, opt, vm) => {
                axios.post('/tasks', {
                    search: escape(search),
                    selected: vm.selected,
                    opt: opt
                }).then(response => {
                    switch (opt) {
                        case 'directors':
                            vm.options.directors = response.data
                            break
                        case 'statuses':
                            vm.options.statuses = response.data
                            break
                        case 'responsible':
                            vm.options.responsible = response.data
                            break
                        case 'roles':
                            vm.options.roles = response.data
                            break
                        default:
                        // Error: invalid mode.
                    }
                });
                loading(false);
            }, 550),

        }
    }
</script>

<style>

</style>
