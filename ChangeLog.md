## Change Log

### 2016.02.08
- Add 增加知乎专栏类 Column 与知乎文章类 Post
- Add 增加专栏相关测试

### 2016.02.02
- Change 修改 test_topic.php 
- Update 精简 Topic 类冗余代码

### 2016.02.01
- Change 修改 test_question.php，并修复 Question 中的小 bug
- Fix 由于知乎问题回答下默认显示条数由 50 变为 20，修复 Question->answers() 中的 bug

### 2016.01.31
- Change 修改 test_answer.php，使用 phpunit 进行测试
- Change 将 Answer 中获取 aid 单独为一个 aid() 函数，并添加 private aid 属性
- Add 更新 Answer 类，添加 comments_num() 函数获取评论数
- Fix 修复回答下的评论回复与被回复者匿名时产生的 Bug

### 2016.01.27
- Add User 类添加获取用户收藏夹函数 collections()

### 2016.01.22
- Update 更新 Topic 类，添加 parser_entire() 等

### 2016.01.21
- Update 更新 answer 类，替换重复代码
- Fix 修改所有类的 url 属性为 private，并添加 url() 函数
- Fix 添加 dom 属性

### 2016.01.20
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
- CHange 修改 Comment 类中的 reply 为 replyed

### 2016.01.09
- Fix 完善 Collection 类 get_answers()

### 2016.01.08
- Add 添加获取话题最新问题 get_new_question()
- Fix 修复 Topic 中获取精华回答的错误，修改 get_top_question() 为 get_top_answer()

### 2016.01.07
- Update 更新 Topic 中的 get_hot_question(),get_top_question()以及 get_all_question() 使它们能够获取所有问题

### 2016.01.06
- Add 在 Answer 类中添加获取点赞用户的函数 get_voters()

### 2016.01.05
- Update 去除所有类中的属性名称前缀
- Add 添加遗漏的 Topic 类中的 get_name() 函数

### 2016.01.03
- Fix 修复每次获取数据时都重新解析网页的 Bug