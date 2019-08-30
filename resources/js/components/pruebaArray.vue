<template>

<div id="app">
  <table>
    <tr v-for="(invoice_item, index) in itemsWithSubTotal" :key="index">
        <td>{{ invoice_item.name }}</td>
        <td><input type="number" class="inline-edit" v-model="invoice_item.item.rate"></td>
        <td><input type="number" class="inline-edit" v-model="invoice_item.item.quantity"></td>
        <td><input type="number" class="inline-edit" v-model="invoice_item.item.activation_fee"></td>
        <td class="subtotal">{{ invoice_item.subtotal }}</td>
    </tr>





  </table>
  Total: {{totalByCategory["widgets"]}}
</div>

</template>


<script>
export default {
    
  data() {
    invoice_items: [
      {
        name: "Community / Support",
        rate: 5.20,
        quantity: 1,
        activation_fee: 3.00,
        category: "widgets"
      },
      {
        name: "Infrastructure",
        rate: 269.00,
        quantity: 3,
        activation_fee: 1.00,
        category: "widgets"
      },
      {
        name: "Infrastructure",
        rate: 269.00,
        quantity: 3,
        activation_fee: 1.00,
        category: "stuff"
      },
    ]
  },
  computed: {
    // probably need a better name for this, but its just an example
    itemsWithSubTotal() {
      return this.invoice_items.map(item => ({
          item,
          subtotal: this.computeSubTotal(item)
      }))
    },
    // calculate the total of all the subtotalItems grouped by category
    totalByCategory() {
      // group the items by category
      let grouped = this.itemsWithSubTotal
        .reduce((acc, val) => {
          // This line does everything the lines below do, but in a very
          // terse, possibly confusing way.
          //(acc[val.item.category] = acc[val.item.category] || []).push(val)
          
          //if there is not already an array set up for the current
          //category, add one
          if (!acc[val.item.category]) 
            acc[val.item.category] = []
          // push the current value into the collection of values
          // for this category
          acc[val.item.category].push(val)
          // return the accumulator (object)
          return acc
        }, {})
        
      // create an object that has the total for each category
      return Object.keys(grouped).reduce((acc, val) => {
        acc[val] = grouped[val].reduce((total, item) => total += item.subtotal, 0)
        return acc
      }, {})
    }
  },
  methods: {
    computeSubTotal: function(invoice_item) {
      //formatPrice is removed here because its not defined in the question
      return ((parseFloat(invoice_item.rate) * parseFloat(invoice_item.quantity) + parseFloat(invoice_item.activation_fee)));
    },
  }

}
</script>
