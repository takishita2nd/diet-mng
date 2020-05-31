<template>
    <div>
        <table class="weightlist">
            <tbody>
                <tr>
                    <th class="date">日時</th>
                    <th class="weight">体重(kg)</th>
                    <th class="fat_rate">体脂肪(%)</th>
                    <th class="bmi">BMI</th>
                    <th class="edit"></th>
                    <th class="delele"></th>
                </tr>
                <tr v-for="data in datalists">
                    <td class="date">{{ data.date}}</td>
                    <td class="weight">{{ data.weight}}</td>
                    <td class="fat_rate">{{ data.fat_rate}}</td>
                    <td class="bmi">{{ data.bmi}}</td>
                    <td class="edit"><a href="">Edit</a></td>
                    <td class="delele"><a href="">Delete</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
        data() {
        return {
            datalists: [],
        };
    },
    created: function() {
        var self = this;
        axios.post('api/weight/list').then(function(response){
            response.data.dataLists.forEach(element => {
                self.datalists.push({
                    date: element.datetime,
                    weight: element.weight,
                    fat_rate: element.fat_rate,
                    bmi: element.bmi
                })
            });
        }).catch(function(error){
        });
    }
}
</script>