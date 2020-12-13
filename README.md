# 多租户订单管理系统

## 数据库分布

<details>
<summary>数据库分为公共库和业务分库，可能还会有若干特定功能库</summary>

**1 公共库 db** 

用户表  
user  
user_info  

菜单表  
node  

租户表  
partner  

**2 业务分库**

以租户ID分库 oms_partner_xxxx (xxx 为租户ID，固定长度8位，不足左补零) , 保持业务数据隔离  

部门信息表  
department  

权限相关  
role 权限组  
role_node 权限组拥有的权限，建议遵循最小权限原则  
role_user 用户拥有的权限组，建议遵循最小权限原则  
</details>

## 标准化部署

提供 dockerfile , 建议使用腾讯云 tke 拖管集群。也提供一个 docker-compose.yml 配置，方便开发环境统一。  

软件版本 nginx-1.19.5，php-8.0.0, mysql-5.7, redis5.0 。 根据需要，不定期更新。  

## Migration

通过 migration 来管理，并在各个业务分库保持 schema 一致  

- [x] migration up
- [ ] migration down
- [x] 支持黑白名单
- [ ] 支持约束
- [ ] 对账

## 功能和权限管理

这两个功能共用独立 DB，多租户共用同一 DB。用户表，权限组表，部门表增加 partner_id 字段用来区分租户

租户标识用 session 来记录

- [x] 功能管理  

  - [x] 菜单列表  

  - [x] 添加菜单

  - [x] 租户管理

- [ ] 权限管理  

  - [x] 权限组管理  
  权限组区分租户，对应数据表 role，partner_id 字段为租户ID

  - [ ] 权限设置  
  只能设置自己有权限的权限组，并且只能更新自己有权限的节点。建议遵循最小权限原则。

  - [ ] 权限分配
  只能给用户分配当前登录账户有权限的权限组，若用户有绑定其他权限组，相应的权限保留。  
  管理员可分配所有人的权限，部门负责人可修改自己部门员工的权限。  
  
  - [ ] 权限初始化脚本
  
  - [ ] 访问控制

