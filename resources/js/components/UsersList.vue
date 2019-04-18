<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Users list</div>

                    <div class="card-body">
                        <template>
                            <b-container fluid>
                                <!-- User Interface controls -->
                                <b-row>
                                    <b-col md="6" class="my-1">
                                        <b-form-group label-cols-sm="3" label="Filter" class="mb-0">
                                            <b-input-group>
                                                <b-form-input v-model="filter" placeholder="Type to Search"></b-form-input>
                                                <b-input-group-append>
                                                    <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
                                                </b-input-group-append>
                                            </b-input-group>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="6" class="my-1">
                                        <b-form-group label-cols-sm="3" label="Sort" class="mb-0">
                                            <b-input-group>
                                                <b-form-select v-model="sortBy" :options="sortOptions">
                                                    <option slot="first" :value="null">-- none --</option>
                                                </b-form-select>
                                                <b-form-select v-model="sortDesc" :disabled="!sortBy" slot="append">
                                                    <option :value="false">Asc</option> <option :value="true">Desc</option>
                                                </b-form-select>
                                            </b-input-group>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="6" class="my-1">
                                        <b-form-group label-cols-sm="3" label="Sort direction" class="mb-0">
                                            <b-input-group>
                                                <b-form-select v-model="sortDirection" slot="append">
                                                    <option value="asc">Asc</option> <option value="desc">Desc</option>
                                                    <option value="last">Last</option>
                                                </b-form-select>
                                            </b-input-group>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="6" class="my-1">
                                        <b-form-group label-cols-sm="3" label="Per page" class="mb-0">
                                            <b-form-select v-model="perPage" :options="pageOptions"></b-form-select>
                                        </b-form-group>
                                    </b-col>
                                </b-row>

                                <!-- Main table element -->
                                <b-table
                                    show-empty
                                    stacked="md"
                                    :items="items"
                                    :fields="fields"
                                    :current-page="currentPage"
                                    :per-page="perPage"
                                    :filter="filter"
                                    :sort-by.sync="sortBy"
                                    :sort-desc.sync="sortDesc"
                                    :sort-direction="sortDirection"
                                    @filtered="onFiltered"
                                >
                                    <template slot="name" slot-scope="row">
                                        {{ row.value }}
                                    </template>

                                    <template slot="actions" slot-scope="row">
                                        <b-button size="sm" @click="row.toggleDetails">
                                            {{ row.detailsShowing ? 'Hide' : 'Show' }} Details
                                        </b-button>
                                    </template>

                                    <template slot="row-details" slot-scope="row">
                                        <b-card>
                                            <ul>
                                                <li v-for="(value, key) in row.item" :key="key">{{ key }}: {{ value }}</li>
                                            </ul>
                                        </b-card>
                                    </template>
                                </b-table>

                                <b-row>
                                    <b-col md="6" class="my-1">
                                        <b-pagination
                                            v-model="currentPage"
                                            :total-rows="totalRows"
                                            :per-page="perPage"
                                            class="my-0"
                                        ></b-pagination>
                                    </b-col>
                                </b-row>
                            </b-container>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'UsersList',
        props: {
            route: {
                type: String,
                default: ''
            }
        },
        data() {
            return {
                fields: [
                    { key: 'id' },
                    { key: 'name', label: 'Name', sortable: true, sortDirection: 'desc' },
                    { key: 'email', label: 'Email', sortable: true, class: 'text-center' },
                    { key: 'created_at', label: 'Registration datetime' },
                    { key: 'actions', label: 'Actions' }
                ],
                totalRows: 1,
                currentPage: 1,
                perPage: 5,
                pageOptions: [5, 10, 15],
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',
                filter: null
            }
        },
        computed: {
            items: function () {
                return this.$store.state.users.users
            },
            sortOptions() {
                // Create an options list from our fields
                return this.fields
                    .filter(f => f.sortable)
                    .map(f => {
                        return { text: f.label, value: f.key }
                    })
            }
        },
        mounted() {
            // Set the initial number of items
            this.totalRows = this.items.length
        },
        created () {
            this.setRoute()
            this.$store.dispatch('users/getUsers')
        },
        methods: {
            setRoute: function () {
                this.$store.dispatch('users/setRoute', this.route)
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            }
        }
    }
</script>
