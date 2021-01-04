'use strict'
const {Model} = require('sequelize');
module.exports = (sequelize, DataTypes) => {
    class Category extends Model {
        static associate(models) {
            // define association here
        }
    };
    Category.init({
        name: DataTypes.STRING,
        slug: DataTypes.STRING,
        description: DataTypes.STRING,
        parent: DataTypes.INTEGER,
        status: DataTypes.INTEGER,
        createdAt: { type:DataTypes.DATE, field:'created_at' },
        updatedAt: { type:DataTypes.DATE, field:'updated_at' },
    }, {
        sequelize,
        modelName: 'Category',
        tableName: 'post_categories',
    });
    return Category;
}
