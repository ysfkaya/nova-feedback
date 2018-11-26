Nova.booting((Vue, router) => {
    window._requestPrefixFeedback = '/nova-vendor/nova-feedback';

    router.addRoutes([
        {
            name: 'show.errorReport',
            path: '/errorReport/show/:id',
            component: require('./components/Error/Detail'),
            props: route => {
                return {
                    resourceId: route.params.id
                }
            }
        }
    ])
})
