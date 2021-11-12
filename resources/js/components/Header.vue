<template>
    <div class="header">
        <el-input placeholder="请输入索引" v-model="search" class="search">
            <template slot="prepend">{{ webUrl }}/</template>
            <el-button slot="append" icon="el-icon-arrow-right">前往</el-button>
        </el-input>
        <div>123</div>
    </div>
</template>

<script>
export default {
    name: "Header",
    props: {
        webUrl: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            search: "",
        }
    },
    methods: {
        handleClick() {
            this.$message.success("点击了按钮");
        }
    }
}
</script>

<style scoped lang="scss">
.header {
    padding: 8px 16px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    .search {
        width: 60%;
    }
}
</style>
