<template>
    <div>
        <div>
            <p id="navi">> <a href="/home">HOME</a></p>
            <p id="inputbutton">
                <button @click="onClickInput">データ入力</button>
            </p>
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
                        <td class="edit"><a @click="onClickEdit(data.id)">Edit</a></td>
                        <td class="delele"><a href="">Delete</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div>
            <weight-input-dialog-component :show="showInputDialogContent" @update="invokeUpdateList"></weight-input-dialog-component>
            <weight-edit-dialog-component ref="editDialog" :show="showEditDialogContent" @update="invokeUpdateList"></weight-edit-dialog-component>
        </div>
    </div>
</template>

<script>
export default {
        data() {
        return {
            showInputDialogContent: false,
            showEditDialogContent: false,
            datalists: [],
        };
    },
    created: function() {
        this.updateList();
    },
    methods: {
        onClickInput: function() {
            this.showInputDialogContent = true;
        },
        onClickEdit: function(id) {
            var editData = {};
            this.datalists.forEach(element => {
                if(element.id == id){
                    editData.id = id;
                    editData.weight = element.weight;
                    editData.fat_rate = element.fat_rate;
                    editData.bmi = element.bmi;
                    return true;
                }
            });
            this.$refs.editDialog.dataSet(editData);
            this.showEditDialogContent = true;
        },
        invokeUpdateList: function() {
            this.updateList();
        },
        updateList: function() {
            this.datalists = [];
            var self = this;
            axios.post('api/weight/list').then(function(response){
                response.data.dataLists.forEach(element => {
                    self.datalists.push({
                        id: element.id,
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
}
</script>