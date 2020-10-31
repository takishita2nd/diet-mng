<template>
    <div>
        <div>
            <p id="navi"> <a href="/home">HOME</a></p>
            <table class="eatinghistory">
                <tbody>
                    <tr>
                        <th class="check">
                            <input type="checkbox" />
                        </th>
                        <th class="date">日時</th>
                        <th class="item">アイテム</th>
                        <th class="protein">タンパク質</th>
                        <th class="liqid">脂質</th>
                        <th class="carbo">炭水化物</th>
                        <th class="calorie">カロリー</th>
                    </tr>
                    <tr v-for="data in datalists">
                        <td class="check">
                            <input type="checkbox" />
                        </td>
                        <td class="date">{{ data.date}}</td>
                        <td class="item">{{ data.item}}</td>
                        <td class="protein">{{ data.protein}}</td>
                        <td class="liqid">{{ data.liqid}}</td>
                        <td class="carbo">{{ data.carbo}}</td>
                        <td class="calorie">{{ data.calorie}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            datalists: [],
            param: {},
            contents: {
                page: "",
            },
        };
    },
    created: function() {
        this.updateList();
    },
    methods: {
        updateList: function() {
            this.datalists = [];
            this.param.contents = this.contents;
            var self = this;
            axios.post('/api/eating/history', this.param).then(function(response){
                response.data.dataLists.forEach(element => {
                    self.datalists.push({
                        date: element.created_at,
                        item: element.item,
                        protein: element.protein,
                        liqid: element.liqid,
                        carbo: element.carbo,
                        calorie: element.calorie
                    })
                });
            }).catch(function(error){
            });
        }
    }
}
</script>