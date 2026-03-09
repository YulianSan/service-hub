import { route as routeZiggy } from 'ziggy-js';
import { Ziggy } from '@/ziggy'

export const route = (name: string, params?: any) =>
    routeZiggy(name, params, undefined, Ziggy)
