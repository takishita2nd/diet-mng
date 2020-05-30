<template>
    <div>
        <div class="dashboard">
            <div class="chart">
                <canvas id="weight"></canvas>
            </div>
            <div class="command">
                <ul>
                    <li><a @click="onClickInput">クイック入力</a></li>
                    <li><a href="">詳細</a></li>
                </ul>
            </div>
        </div>
        <weight-input-dialog-component :show="showDialogContent"></weight-input-dialog-component>
    </div>
</template>

<script>
export default {
    data() {
        return {
            showDialogContent: false,
        };
    },
    created: function() {

    },
    methods: {
        onClickInput: function() {
            this.showDialogContent = true;
        },
    }
}
</script>