const jwt = require('jsonwebtoken');

const validateToken = (req, res, next) => {
    const token = req.header('token');
    if (!token) return res.status(401).send({
        status: 401,
        message: 'Access denied'
    });

    try {
        const verified = jwt.verify(token, process.env.TOKEN_SECRET);
        req.user = verified;
        next();
    } catch(err) {
        res.status(400).send({
            status: 400,
            message: 'Invalid token'
        });
    }
}

module.exports = {
    validateToken
}