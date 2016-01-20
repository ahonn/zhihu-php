## Change Log

### 2016.1.20
- Fix 重写 question 类获取关注者及回答相关函数
- Add 增加获取问题关注者及回答的公共函数

### 2016.01.15
- Update 去除所有类中函数名的 `get` 前缀
- Add User 类增加获取用户微博链接
- Fix 重写 User 类获取用户信息相关函数
- Fix 修复 Collection 类中因为回答建议修改而产生的错误，其他类暂时还没有修复 

### 2016.01.13
- Fix 根据知乎前端回答评论更新为分页显示，修复获取回答评论时的 Bug

### 2016.01.11
- Add 添加 Comment 类测试
- Fix 修改 Comment 类中的 reply 为 replyed
- Fix 修改 Answer 类文档中与 Comment 相关内容

### 2016.01.09
- Fix 完善 Collection 类 get_answers()
- Add 添加 Collection 类文档

### 2016.01.08
- Add 添加获取话题最新问题 get_new_question()
- Fix 修复 Topic 中获取精华回答的错误，修改 get_top_question() 为 get_top_answer()
- Fix 修正 Topic 类的文档

### 2016.01.07
- Update 更新 Topic 中的 get_hot_question(),get_top_question()以及 get_all_question() 使它们能够获取所有问题
- Add 添加 Topic 类的文档

### 2016.01.06
- Add 在 Answer 类中添加获取点赞用户的函数 get_voters()

### 2016.01.05
- Update 去除所有类中的属性名称前缀，将所有类中的 $url 设为 public，并去除 get_url() 函数
- Add 添加遗漏的 Topic 类中的 get_name() 函数
- Update 根据上述修改更新文档

### 2016.01.04
- Add 添加 Answer 类的文档

### 2016.01.03
- Fix 修复每次获取数据时都重新解析网页的 Bug
- Add 新增 examples 文件夹，添加下载用户所关注的妹子头像的例子
- Add 添加 Question 类的文档