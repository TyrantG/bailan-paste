# 摆烂剪贴板
摆，就硬摆

## 接口使用

### 创建剪贴板

#### Request

| Method | URL | Description |
| :---: | --- | --- |
| `POST` | `https://pasteme.tyrantg.com/api/create` | 创建剪贴板 |

##### Headers

`Content-Type: application/json`

##### Body

###### Params

| Name | Type | Description | Required |
| :---: | :---: | --- | :---: |
| content | text | 剪贴板内容 | Yes |
| password | string | 剪贴板密码 | No |
| count_limit | int | 限制浏览次数 | No |
| time_limit | int | 限制浏览时间（分钟） | No |
| return_type | int | 返回链接类型 0：递增id 1:随机url 默认1 | No |
| auto_password | int | 自动生成6位密码 0：不生成 1:生成 默认0 优先级低于password | No |

###### Example

```json
{
  "content": "寄",
  "password": "123456"
}
```

or

```json
{
  "content": "寄",
  "password": "123456",
  "time_limit": 60
}
```

or

```json
{
    "content": "寄",
    "return_type": 0,
    "auto_password": 1
}
```

### Response

#### Headers

`Content-Type: application/json`

#### Body

##### Params

| Name | Type | Description |
| :---: | :---: | --- |
| password | string | 密码 |
| path | string | 文本地址 |

##### Example

```json
{
    "return_code": 0,
    "result_code": "SUCCESS",
    "data": {
        "password": "9u1XWm",
        "path": "kt9smknsvaricptg"
    },
    "message": "请求成功"
}
```


### 获取剪贴板内容

#### Request

| Method | URL | Description |
| :---: | --- | --- |
| `GET` | `https://pasteme.tyrantg.com/api/getContent/:path` | 获取剪贴板内容 |

##### Headers

`Content-Type: application/json`

##### Url Path Parameters
path 结构： <br>
无密码时为：path <br>
有密码时为：path@password


### Response

#### Headers

`Content-Type: application/json`

##### Example

```json
{
    "return_code": 0,
    "result_code": "SUCCESS",
    "data": "寄",
    "message": "请求成功"
}
```
