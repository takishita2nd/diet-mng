<template>
    <div>
        <div>
            <p id="navi">> <a href="/home">HOME</a></p>
            <table class="eatinglist">
                <tbody>
                    <tr>
                        <th class="date">日時</th>
                        <th class="protein">タンパク質</th>
                        <th class="liqid">脂質</th>
                        <th class="carbo">炭水化物</th>
                        <th class="calorie">カロリー</th>
                        <th class="edit"></th>
                    </tr>
                    <tr v-for="data in datalists">
                        <td class="date">{{ data.date}}</td>
                        <td class="protein">{{ data.protein}}</td>
                        <td class="liqid">{{ data.liqid}}</td>
                        <td class="carbo">{{ data.carbo}}</td>
                        <td class="calorie">{{ data.calorie}}</td>
                        <td class="edit"><a @click="onClickEdit(data.date)">Edit</a></td>
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
            url: "eating/detail"
        };
    },
    created: function() {
        this.updateList();
    },
    methods: {
        onClickEdit: function(date) {
            window.location = this.url + "/" + date;
        },
        updateList: function() {
            this.datalists = [];
            this.param.contents = this.contents;
            var self = this;
            axios.post('api/eating/list', this.param).then(function(response){
                response.data.dataLists.forEach(element => {
                    self.datalists.push({
                        date: element.date,
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