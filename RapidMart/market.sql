-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 17-06-2024 a las 21:40:57
-- Versión del servidor: 8.0.36-0ubuntu0.22.04.1
-- Versión de PHP: 8.3.3-1+ubuntu22.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `market`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Administradores`
--

CREATE TABLE `Administradores` (
  `id` int NOT NULL,
  `idUsuario` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id` int NOT NULL,
  `idProducto` int NOT NULL,
  `idUsuario` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`id`, `idProducto`, `idUsuario`) VALUES
(75, 81, 6),
(76, 75, 6),
(77, 76, 6),
(78, 75, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id` int NOT NULL,
  `idProducto` int NOT NULL,
  `idUsuario` int NOT NULL,
  `precio` int NOT NULL,
  `idVendedor` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id`, `idProducto`, `idUsuario`, `precio`, `idVendedor`) VALUES
(118, 75, 11, 36, 6),
(119, 76, 11, 26, 11),
(120, 76, 11, 26, 11),
(121, 75, 11, 36, 6),
(122, 75, 11, 36, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int NOT NULL,
  `nombre` varchar(200) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` varchar(300) COLLATE utf8mb4_spanish_ci NOT NULL,
  `foto` varchar(200) COLLATE utf8mb4_spanish_ci NOT NULL,
  `precio` double NOT NULL,
  `idVendedor` int NOT NULL,
  `stock` int NOT NULL,
  `categoria` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `especificaciones` varchar(5000) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `foto`, `precio`, `idVendedor`, `stock`, `categoria`, `especificaciones`) VALUES
(75, 'soundcore Q20i ', 'Cascos Inalámbricos Bluetooth con Cancelación de Ruido Activa Híbridos by Anker, Reproducción ANC 40 Horas, Hi-Res Audio, Personalización vía App, Modo Transparencia, Graves Profundos', '9827cded9bb9e355288854d0c792e2cf.jpg', 36, 6, 22, 'accesorios', '​​CANCELACIÓN DE RUIDO ACTIVA HÍBRIDA: 2 micrófonos internos y 2 externos funcionan en conjunto para detectar el ruido externo y reducirlo de manera efectiva hasta en un 90 %, como los motores de aviones y coches. SUMÉRJASE EN UN AUDIO DETALLADO: los auriculares con cancelación de ruido tienen controladores dinámicos de gran tamaño de 40 mm que producen un sonido detallado y graves intensos con la tecnología BassUp. Compatible con audio con certificación de alta resolución a través del cable AUX para obtener más detalles. BATERÍA DE LARGA DURACIÓN DE 40 HORAS Y CARGA RÁPIDA: Con 40 horas de duración de la batería con ANC activada y 60 horas en modo normal, puede viajar tranquilamente sin pensar en recargar. Carga rápida durante 5 minutos para obtener 4 horas de tiempo de reproducción adicionales. CONEXIONES DUALES: conéctese simultáneamente a dos dispositivos con Bluetooth 5.0 y pase de uno a otro al instante. Tanto si está trabajando en su portátil como si necesita atender una llamada telefónica, el audio se reproducirá automáticamente desde el dispositivo que necesita escuchar. APLICACIÓN PARA LA PERSONALIZACIÓN DEL ECUALIZADOR: descargue la aplicación soundcore para adaptar el sonido usando el ecualizador personalizable, con 22 opciones predeterminadas, o ajústelo usted mismo. También puede cambiar entre 3 modos: ANC, Normal y Transparencia, y relajarse con el ruido blanco.'),
(76, 'Logitech G203 LIGHTSYNC', 'Ratón USB Gaming con Iluminación RGB Personalizable, 6 Botones Programables, Captor 8K para Gaming, Seguimiento de hasta 8,000 DPI, Ultra-ligero - Negro', 'b598e9bff6279504be139be18c28560b.jpg', 26, 11, 28, 'accesorios', 'SENSOR PARA GAMERS: Seguimiento ultrapreciso gracias al sensor de 8000 DPI. Alterna entre los 5 perfiles de configuración, así como el mapeo de pantalla con el G HUB, para un rendimiento más estable LIGHTSYNC RGB: Gracias a sus 16,8 millones de colores, tendrás el arco iris al alcance de la mano. Combina patrones y juega con efectos ópticos que se adaptan a todos tus estados de ánimo DISEÑO PARA GAMERS: Su sencillo diseño de 6 botones ofrece una experiencia de juego única. Cómodo y resistente, facilita un control total. Además, permite programar tareas con botones configurables RESISTENCIA MECÁNICA DEL RESORTE DEL BOTÓN: Los botones mecánicos se apoyan en resortes metálicos de lo más resistentes. Los clics son muy precisos y te ofrecen retroalimentación para adaptarse a ti CONFIGURACIÓN PERSONALIZABLE: Compatible con el software de juego Logitech G HUB con el que podrás personalizar tu configuración. Elige entre 200 y 8000 DPI para una precisión y agilidad jamás vistas La marca de accesorios para gaming más vendida del mundo: Basado en datos de ventas agregados independientes (febr. 2019 - febr. 2020) de teclados, ratones y auriculares para PC gaming en unidades'),
(78, 'Steelseries Rival 3', 'Ratón Alámbrico para Juegos - Sensor Óptico Truemove Core de 8.500 Cpi - 6 Botones Programables - Botones con Disparador Dividido - Cableado - Negro', '1a10ed88d84d00219ba822c9b2c6598e.jpg', 27, 11, 15, 'accesorios', 'Materiales hiperduraderos: fabricados con polímero ultrarresistente para una larga vida útil. Construcción de la base: plástico ABS Interruptores mecánicos con 60 millones de clics: precisión desde el primer hasta el último clic Sensor óptico TrueMove Core para juegos: seguimiento real de 1:1, 8500 CPI, 300 FPS, aceleración de 35 G Construcción cómoda y ergonómica: el diseño ergonómico garantiza sesiones de juego intensas Iluminación prismática brillante: la iluminación rediseñada ofrece 3 zonas con 16,8 millones de colores hermosos y ultra nítidos NOTA: Compruebe la compatibilidad del dispositivo y asegúrese de que esté instalado el firmware más reciente.'),
(79, 'Razer Viper V3 Pro', 'Ratón inalámbrico Ultraligero Esports Gaming (8K Hz HyperPolling, diseño Ligero de 55g, Sensor Focus Pro 35K dpi, HyperSpeed Wireless, 95 Horas de duración) Blanco', '769465cf2e298c83aa8880868a94ec02.jpg', 164, 11, 10, 'accesorios', 'Diseño ultraligero de 55 g: manejo perfecto, máximo control: Diseñado en colaboración con profesionales de esports de talla mundial, el diseño ultraligero y perfectamente equilibrado del Viper V3 Pro te permite realizar gestos rápidos y precisos que se ajustan a todas tus intenciones. Sensor óptico Razer Focus Pro 35K DPI Gen-2 - La mejor precisión de su clase: Experimenta un rendimiento de seguimiento de nivel profesional en una mayor variedad de superficies, incluido el cristal, con el apoyo de funciones inteligentes y ajustes por pasos de 1 PPP para una puntería y un control más granulares. Tecnología Razer 8K Hz HyperPolling - Respuesta de latencia ultrabaja: Al combinar Razer HyperPolling con la conexión ultrasuave de Razer HyperSpeed, experimenta un rendimiento inalámbrico impecable con una velocidad de sondeo real de hasta 8000 Hz. Razer HyperSpeed Wireless: conexión ultrasuave: Con un diseño de dongle optimizado que no hace concesiones en la conexión, disfruta de un rendimiento inalámbrico de primer nivel que se mantiene fluido y fiable incluso en entornos de torneo ruidosos. Ratón óptico Razer Gen-3 - Durabilidad y velocidad inigualables: Desde un ciclo de vida mejorado de 90 millones de clics con cero problemas de doble clic, hasta una actuación fulminante de 0,2 ms sin retardo de rebote, disfruta de una fiabilidad y velocidad que eclipsa a todas las demás. Hasta 95 horas de duración de la batería: sin interrupciones en los juegos: Disfruta de hasta 95 horas de juego competitivo de alto rendimiento en tus torneos y partidas más intensas.'),
(80, 'JBL LIVE 660NC', 'Auriculares circumaurales inalámbricos con cancelación adaptativa de ruido, tecnología Bluetooth, hasta 50h de batería sin NC, asistente de voz y conexión multipunto, negro', '33ad387e7a92044aab96a3b65936a655.jpg', 99, 11, 30, 'accesorios', 'Disfruta de hasta 50 hrs de reproducción (con ANC apagada), de unos bajos mejorados y del inconfundible sonido JBL gracias a los LIVE 660NC de JBL, equipados con unos drivers potentes de 40 mm Aíslate del entorno cuando tú quieras con la cancelación adaptativa de ruido, aumenta el sonido ambiental gracias a la tecnología Ambient Aware o charla con los auriculares puestos con TalkThru Cambia de un dispositivo Bluetooth a otro con la conexión multipunto: pasa de un vídeo a tu tableta o a tu móvil en un instante. Haz llamadas con el kit manos libres y disfruta de un audio estéreo Muy cómodos, con una banda de sujeción de tela y suaves almohadillas, los Live 460NC incluyen una bolsa de transporte para protegerlos. Descubre la aplicación My JBL Headphones y personalízalos Contenido del envío: 1x JBL LIVE 660 NC Auriculares circumaurales inalámbricos con tecnología Bluetooth, bolsa de transporte, cable de carga tipo C, cable de sonido, guía de inicio rápido, en negro Conectividad: se requiere Android 6.0 o superior para tener acceso completo a las funciones de Alexa al utilizar este dispositivo'),
(81, 'PowerLocus', 'Auriculares Inalámbricos Bluetooth de Diadema, Cascos Bluetooth con Micrófono para niñas y niños con 85DB Volumen Limitado, Auriculares Plegable, Ajustable', '75e7dd9e2e88c5b2a130663c96ce45c3.jpg', 24, 11, 50, 'accesorios', '[Volumen máximo seguro de protección auditiva 85DB] - Los auriculares de diadema PowerLocus van proteger a tus hijos de los daños auditivos poniendo un límite de volumen máximo de 85db. Este límite ha sido probado como un estándar mundial para ser seguro para los niños. Audio cristalino con bajos enriquecidos que permitirá a los pequeños audiófilos disfrutar de sus canciones favoritas. [Diseño suave y ligero] - Los auriculares plegables para niños, que se pueden llevar en un estuche, caben fácilmente en cualquier mochila o maleta. Equipados con orejeras y diadema súper suaves, su diseño ligero sobre la oreja proporcionará a tu hijo una comodidad duradera. Los auriculares cubren la oreja completamente para asegurar un perfecto aislamiento del sonido. [Bluetooth 5.3,habilitado como auxiliar, FM y Micro SD] - Con nuestros auriculares bluetooth diadema, tus hijos van a tener la libertad de cambiar fácilmente entre varios modos. Nuestros auriculares para niños son universalmente compatibles y se emparejan instantáneamente con iOS, Android, Windows, Mac, etc. con un enorme alcance inalámbrico de hasta 10 metros. Son cascos bluetooth y cable que se conectan sin problemas a las consolas de juegos como PS4, PS5, Xbox y Switch para escuchar y hablar [Auriculares inalámbricos con micrófono] - Micrófonos externos e incorporados diseñados para mejorar la experiencia de aprendizaje en línea de sus hijos. Los cascos bluetooth para niños con un suave modo de manos libres están disponibles tanto en el modo con cable como en el modo Bluetooth. Con el control de volumen de los oídos, la reproducción/pausa, el asistente de voz y la aceptación/rechazo de las llamadas entrantes facilitarán sus momentos de alegría. [SOPORTE Y GARANTÍA] - Estás cubierto con 3 años de garantía de PowerLocus y 100% de satisfacción del cliente con una política de devolución sin preguntas. Pónte en contacto con nosotros y te vamos a responder en menos de 2 horas o llámanos 7 días a la semana a nuestro soporte telefónico gratuito en el España - ¡disponible para ayudarte en cualquier momento! Hay disponible un envoltorio de regalo gratuito para que puedas presentar el regalo perfecto para tus seres queridos.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `nombre` varchar(200) COLLATE utf8mb4_spanish_ci NOT NULL,
  `apellidos` varchar(200) COLLATE utf8mb4_spanish_ci NOT NULL,
  `correo` varchar(200) COLLATE utf8mb4_spanish_ci NOT NULL,
  `password` varchar(200) COLLATE utf8mb4_spanish_ci NOT NULL,
  `rol` varchar(200) COLLATE utf8mb4_spanish_ci NOT NULL,
  `foto` varchar(200) COLLATE utf8mb4_spanish_ci NOT NULL,
  `sid` varchar(200) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `correo`, `password`, `rol`, `foto`, `sid`) VALUES
(6, 'pepe', 'labrador', 'pepe@gmail.com', '$2y$10$y1v8XbZJ8UgDWONJaXkaFev3nCKPVtzQ5R5zcLJghc6Fk6AM96n02', 'Cliente,vendedor,admin', 'b17fb4be6db3bcd7d09de6c6fd5ab3e6.jpeg', '8155431cea8bf919e9c991e003e3634a13ea9277'),
(11, 'pepe', 'penia', 'julia@gmail.com', '$2y$10$ZhnUacDZrAXQaZrnDE6yY.8enOTgJnsGl7QwCPSAf5E3UOQfJC706', 'Cliente,Vendedor', '50b5f2ef4010de626f29d810baaaa11d.jpeg', '9fa736e32fa47cc5ffe131442219b0755af92cc1'),
(13, 'isma', 'lab', 'isma@gmail.com', '$2y$10$qHPTaIKxToMWQl5r/YN93uJ3pdRs8yOmp5FPK2d0D3FNaSfVRxbDa', 'Cliente', '1f5499459263b25bf2e2bc2dae4a9950.jpeg', '1e03b6a2c7aa07e0aeac1565694a49e1151e0a11');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Administradores`
--
ALTER TABLE `Administradores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Administradores`
--
ALTER TABLE `Administradores`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
