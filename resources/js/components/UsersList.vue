<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            Users list
          </div>

          <div class="card-body">
            <template>
              <b-container fluid>
                <!-- User Interface controls -->
                <b-row>
                  <b-col
                    md="4"
                    class="my-1"
                  >
                    <b-form-group
                      label-cols-md="2"
                      label="Filter"
                      class="mb-0"
                    >
                      <b-input-group>
                        <b-form-input
                          v-model="filter"
                          placeholder="Type to Search"
                        />
                        <b-input-group-append>
                          <b-button
                            variant="danger"
                            :disabled="!filter"
                            @click="filter = ''"
                          >
                            Clear
                          </b-button>
                        </b-input-group-append>
                      </b-input-group>
                    </b-form-group>
                  </b-col>

                  <b-col
                    md="4"
                    class="my-1"
                  >
                    <b-form-group
                      label-cols-md="2"
                      label="Sort"
                      class="mb-0"
                    >
                      <b-input-group>
                        <b-form-select
                          v-model="sortBy"
                          :options="sortOptions"
                        >
                          <option
                            slot="first"
                            :value="null"
                          >
                            -- none --
                          </option>
                        </b-form-select>
                        <b-form-select
                          slot="append"
                          v-model="sortDesc"
                          :disabled="!sortBy"
                        >
                          <option :value="false">
                            Asc
                          </option>
                          <option :value="true">
                            Desc
                          </option>
                        </b-form-select>
                      </b-input-group>
                    </b-form-group>
                  </b-col>

                  <b-col
                    md="4"
                    class="my-1"
                  >
                    <b-form-group
                      label-cols-md="3"
                      label="Per page"
                      class="mb-0"
                    >
                      <b-form-select
                        v-model="perPage"
                        :options="pageOptions"
                      />
                    </b-form-group>
                  </b-col>
                </b-row>

                <!-- Main table element -->
                <b-table
                  show-empty
                  stacked="md"
                  :items="users"
                  :fields="fields"
                  :current-page="currentPage"
                  :per-page="perPage"
                  :filter="filter"
                  :sort-by.sync="sortBy"
                  :sort-desc.sync="sortDesc"
                  @filtered="onFiltered"
                >
                  <template
                    slot="name"
                    slot-scope="row"
                  >
                    {{ row.value }}
                  </template>

                  <template
                    slot="actions"
                    slot-scope="row"
                  >
                    <b-button
                      size="sm"
                      variant="success"
                      @click="row.toggleDetails"
                    >
                      {{ row.detailsShowing ? 'Hide' : 'Show' }} Details
                    </b-button>
                  </template>

                  <template
                    slot="row-details"
                    slot-scope="row"
                  >
                    <b-card>
                      <ul>
                        <li
                          v-for="(value, key) in row.item"
                          :key="key"
                        >
                          {{ key }}: {{ value }}
                        </li>
                      </ul>
                    </b-card>
                  </template>
                </b-table>

                <b-row>
                  <b-col
                    md="6"
                    class="my-1"
                  >
                    <b-pagination
                      v-model="currentPage"
                      :total-rows="totalRows"
                      :per-page="perPage"
                      class="my-0"
                    />
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
    //
  },
  data () {
    return {
      fields: [
        { key: 'id' },
        { key: 'name', label: 'Name', sortable: true },
        { key: 'email', label: 'Email', sortable: true, class: 'text-center' },
        { key: 'created_at', label: 'Registration datetime' },
        { key: 'actions', label: 'Actions' }
      ],
      currentPage: 1,
      perPage: 5,
      pageOptions: [5, 10, 15],
      sortBy: null,
      sortDesc: false,
      filter: null
    }
  },
  computed: {
    users: function () {
      return this.$store.state.users.users
    },
    totalRows: function () {
      return this.$store.state.users.totalRows
    },
    sortOptions () {
      // Create an options list from our fields
      return this.fields
        .filter(f => f.sortable)
        .map(f => {
          return { text: f.label, value: f.key }
        })
    }
  },
  created () {
    this.$store.dispatch('users/getUsers')
  },
  methods: {
    onFiltered (filteredItems) {
      this.$store.dispatch('users/setTotalRows', filteredItems.length)
      this.currentPage = 1
    }
  }
}
</script>
