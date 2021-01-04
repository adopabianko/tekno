'use strict'
const {Model} = require('sequelize');
module.exports = (sequelize, DataTypes) => {
    class PostCategory extends Model {
        static associate(models) {
            // define association here
        }
    };
    PostCategory.init({
        name: DataTypes.STRING,
        slug: DataTypes.STRING,
        description: DataTypes.STRING,
        parent: DataTypes.INTEGER,
        status: DataTypes.INTEGER,
        createdAt: { type:DataTypes.DATE, field:'created_at' },
        updatedAt: { type:DataTypes.DATE, field:'updated_at' },
    }, {
        sequelize,
        modelName: 'PostCategory',
        tableName: 'post_categories',
    });
    return PostCategory;
}
