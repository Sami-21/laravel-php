<template>
  <v-container>
    <div class="cardsContainer">
      <md-card
        md-with-hover
        v-for="(item, index) in Statistics.headerStats"
        :key="index"
        :style="`background-color:${item.color}`"
      >
        <md-ripple>
          <md-card-header>
            <div class="md-title">{{ item.title }}</div>
            <v-icon>{{ item.icon }}</v-icon>
          </md-card-header>

          <md-card-content> {{ item.count }} </md-card-content>
        </md-ripple>
      </md-card>
    </div>
    <v-container fluid>
      <v-data-iterator :items="top5" hide-default-footer>
        <template v-slot:default="props">
          <v-row>
            <v-col
              v-for="(item, index) in props.items"
              :key="index"
              cols="12"
              sm="6"
              md="6"
              lg="6"
            >
              <v-card>
                <v-card-title class="subheading font-weight-bold">
                  {{ item.name }}
                </v-card-title>

                <v-divider></v-divider>

                <v-list dense>
                  <v-list-item
                    v-for="(element, index) in item.data"
                    :key="index"
                  >
                    <v-list-item-content>
                      {{ element.name }}
                    </v-list-item-content>
                    <v-list-item-content class="align-end">
                      {{ element.count }}
                    </v-list-item-content>
                  </v-list-item>
                </v-list>
              </v-card>
            </v-col>
          </v-row>
        </template>
      </v-data-iterator>
    </v-container>
  </v-container>
</template>

<script>
import axios from "axios";

export default {
  data: () => ({
    Statistics: {
      headerStats: [
        {
          title: "Clients",
          icon: "mdi-account-group",
          color: "#6CCFC1",
          count: 0,
        },
        {
          title: "Providers",
          icon: "mdi-account-wrench",
          color: "#F17374",
          count: 0,
        },
        {
          title: "Products",
          icon: "mdi-package-variant-closed",
          color: "#68ACFA",
          count: 0,
        },
        {
          title: "Transactions",
          icon: "mdi-cash-multiple",
          color: "#F7A83A",
          count: 0,
        },
      ],

      topTransactionsClients: {
        name: "Top 5 Clients (Transactions)",
        data: [],
      },

      topSpendingClients: {
        name: "Top 5 Clients ",
        data: [],
      },

      topSellingProducts: {
        name: "Top 5 Products",
        data: [],
      },

      topTransactions: {
        name: "Top 5 Transactions",
        data: [],
      },
    },
  }),

  created() {
    this.getStats();
  },

  methods: {
    async getStats() {
      new Promise((resolve, reject) => {
        axios
          .get("dashboard")
          .then((res) => {
            console.log(res.data);
            this.Statistics.headerStats.forEach((item, index) => {
              item.count = res.data.count[index];
            });

            res.data.topTransactionsClients.forEach((item) =>
              this.Statistics.topTransactionsClients.data.push({
                name: item.name,
                count: `${
                  item.transactions_count !== null ? item.transactions_count : 0
                } transaction`,
              })
            );

            res.data.topSpendingClients.forEach((item) =>
              this.Statistics.topSpendingClients.data.push({
                name: item.name,
                count: `${item.total !== null ? item.total : 0} DA`,
              })
            );

            res.data.topTransactions.forEach((item) =>
              this.Statistics.topTransactions.data.push({
                name: `Transaction N°${item.id}`,
                count: `${item.total !== null ? item.total : 0} DA`,
              })
            );
            res.data.topSellingProducts.forEach((item) =>
              this.Statistics.topSellingProducts.data.push({
                name: item.name,
                count: `${
                  item.totalSoldUnits !== null ? item.totalSoldUnits : 0
                } unit sold`,
              })
            );
            resolve(res);
          })
          .catch((err) => {
            console.log(err.response);
            reject(err);
          });
      });
    },
  },
  computed: {
    top5() {
      return [
        this.Statistics.topTransactionsClients,
        this.Statistics.topSpendingClients,
        this.Statistics.topSellingProducts,
        this.Statistics.topTransactions,
      ];
    },
  },
};
</script>
      
<style lang="scss" scoped>
.cardsContainer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 20px;
  margin-bottom: 30px;
  color: "#fff";
}

.md-card {
  width: 100%;
  height: 150px;
  vertical-align: top;
}

.md-card-header {
  width: 100%;
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
}

.md-card-content {
  font-size: 42px;
  font-weight: bold;
}

.md-list {
  width: 50%;
  vertical-align: top;
  border: 1px solid rgba(#000, 0.12);
}
</style>