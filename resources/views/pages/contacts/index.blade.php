@extends('layouts.app')

@section('content')
    @php
        $stats = [
          ['icon' => 'users', 'label' => 'Khách hàng hài lòng', 'value' => '10,000+'],
          ['icon' => 'apple', 'label' => 'Loại trái cây', 'value' => '50+'],
          ['icon' => 'award', 'label' => 'Năm kinh nghiệm', 'value' => '15+'],
          ['icon' => 'truck', 'label' => 'Đơn hàng mỗi tháng', 'value' => '5,000+'],
        ];

        $values = [
          ['icon' => 'shield', 'title' => 'Chất lượng đảm bảo', 'description' => 'Cam kết 100% trái cây tươi ngon, được kiểm tra kỹ lưỡng trước khi giao đến tay khách hàng.'],
          ['icon' => 'heart', 'title' => 'Tận tâm phục vụ', 'description' => 'Đội ngũ nhân viên chuyên nghiệp, luôn lắng nghe và hỗ trợ khách hàng 24/7.'],
          ['icon' => 'leaf', 'title' => 'Thân thiện môi trường', 'description' => 'Sử dụng bao bì tái chế, hỗ trợ nông dân địa phương và bảo vệ môi trường.'],
          ['icon' => 'truck', 'title' => 'Giao hàng nhanh chóng', 'description' => 'Hệ thống logistics hiện đại, giao hàng trong 2-4 giờ tại khu vực nội thành.'],
        ];

        $team = [
          ['name' => 'Nguyễn Văn An', 'position' => 'Giám đốc điều hành', 'image' => 'https://images.pexels.com/photos/1239291/pexels-photo-1239291.jpeg?auto=compress&cs=tinysrgb&w=300', 'description' => '15 năm kinh nghiệm...'],
          ['name' => 'Trần Thị Bình', 'position' => 'Trưởng phòng Chất lượng', 'image' => 'https://images.pexels.com/photos/1130626/pexels-photo-1130626.jpeg?auto=compress&cs=tinysrgb&w=300', 'description' => 'Chuyên gia kiểm định...'],
          ['name' => 'Lê Văn Cường', 'position' => 'Trưởng phòng Logistics', 'image' => 'https://images.pexels.com/photos/1130626/pexels-photo-1130626.jpeg?auto=compress&cs=tinysrgb&w=300','description' => 'Quản lý hệ thống...'],
        ];
    @endphp

    <div class="min-h-screen py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Hero --}}
            <div class="text-center mb-16">
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">Về Fresh Fruits</h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Chúng tôi là đơn vị hàng đầu trong việc cung cấp trái cây tươi ngon, chất lượng cao
                    với sứ mệnh mang đến sức khỏe và hạnh phúc cho mọi gia đình Việt Nam.
                </p>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 mb-20">
                @foreach ($stats as $stat)
                    <div class="text-center">
                        <div class="bg-gradient-to-br from-orange-100 to-green-100 p-4 rounded-2xl inline-block mb-4">
                            @switch($stat['icon'])
                                @case('users')
                                <x-heroicon-o-users class="h-8 w-8 text-orange-600" />
                                @break
                                @case('apple')
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-apple text-orange-600"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 11.319c0 3.102 .444 5.319 2.222 7.978c1.351 1.797 3.156 2.247 5.08 .988c.426 -.268 .97 -.268 1.397 0c1.923 1.26 3.728 .809 5.079 -.988c1.778 -2.66 2.222 -4.876 2.222 -7.977c0 -2.661 -1.99 -5.32 -4.444 -5.32c-1.267 0 -2.41 .693 -3.22 1.44a.5 .5 0 0 1 -.672 0c-.809 -.746 -1.953 -1.44 -3.22 -1.44c-2.454 0 -4.444 2.66 -4.444 5.319" /><path d="M7 12c0 -1.47 .454 -2.34 1.5 -3" /><path d="M12 7c0 -1.2 .867 -4 3 -4" /></svg>
                                @break
                                @case('award')
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-award text-orange-600"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9m-6 0a6 6 0 1 0 12 0a6 6 0 1 0 -12 0" /><path d="M12 15l3.4 5.89l1.598 -3.233l3.598 .232l-3.4 -5.889" /><path d="M6.802 12l-3.4 5.89l3.598 -.233l1.598 3.232l3.4 -5.889" /></svg>                                @break
                                @case('truck')
                                <x-heroicon-o-truck class="h-8 w-8 text-orange-600" />
                                @break
                            @endswitch
                        </div>
                        <div class="text-3xl font-bold text-gray-900 mb-2">{{ $stat['value'] }}</div>
                        <div class="text-gray-600">{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>

            {{-- Story --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-20">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Câu chuyện của chúng tôi</h2>
                    <div class="space-y-4 text-gray-600 leading-relaxed">
                        <p>  Fresh Fruits được thành lập vào năm 2009 với khát vọng mang đến cho người tiêu dùng
                            Việt Nam những trái cây tươi ngon nhất từ khắp nơi trên thế giới.</p>
                        <p>   Bắt đầu từ một cửa hàng nhỏ tại TP.HCM, chúng tôi đã không ngừng phát triển và
                            mở rộng quy mô hoạt động. Ngày nay, Fresh Fruits tự hào là đối tác tin cậy của
                            hàng nghìn gia đình và doanh nghiệp trên toàn quốc.</p>
                        <p>Với đội ngũ chuyên gia giàu kinh nghiệm và hệ thống logistics hiện đại, chúng tôi
                            cam kết mang đến dịch vụ tốt nhất, từ khâu tuyển chọn sản phẩm đến giao hàng tận nơi.</p>
                    </div>
                </div>
                <div class="relative">
                    <img src="https://images.pexels.com/photos/1300972/pexels-photo-1300972.jpeg?auto=compress&cs=tinysrgb&w=800"  alt="Fresh Fruits Story" class="w-full h-96 object-cover rounded-3xl shadow-2xl" />
                </div>
            </div>

            {{-- Mission & Vision --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-20">
                <div class="bg-gradient-to-br from-orange-50 to-red-50 p-8 rounded-3xl">
                    <div class="bg-orange-500 p-3 rounded-2xl inline-block mb-6">
                        <x-lucide-target class="h-8 w-8 text-white" />
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Sứ mệnh</h3>
                    <p class="text-gray-600 leading-relaxed">  Mang đến cho mọi gia đình Việt Nam những trái cây tươi ngon, an toàn và bổ dưỡng nhất.
                        Chúng tôi cam kết xây dựng cầu nối bền vững giữa nông dân và người tiêu dùng,
                        góp phần nâng cao chất lượng cuộc sống và sức khỏe cộng đồng.</p>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-blue-50 p-8 rounded-3xl">
                    <div class="bg-green-500 p-3 rounded-2xl inline-block mb-6">
                        <x-heroicon-o-eye class="h-8 w-8 text-white" />
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Tầm nhìn</h3>
                    <p class="text-gray-600 leading-relaxed"> Trở thành thương hiệu trái cây hàng đầu Việt Nam, được khách hàng tin tưởng và lựa chọn.
                        Chúng tôi hướng tới việc mở rộng ra khu vực Đông Nam Á, đồng thời tiên phong trong
                        việc ứng dụng công nghệ để nâng cao trải nghiệm mua sắm.</p>
                </div>
            </div>

            {{-- Values --}}
            <div class="mb-20">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Giá trị cốt lõi</h2>
                    <p class="text-xl text-gray-600">Những nguyên tắc định hướng mọi hoạt động của chúng tôi</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach ($values as $value)
                        <div class="text-center group">
                            <div class="bg-white p-6 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 group-hover:-translate-y-2">
                                <div class="bg-gradient-to-br from-orange-500 to-red-500 p-4 rounded-2xl inline-block mb-6 group-hover:scale-110 transition-transform duration-300">
                                    @switch($value['icon'])
                                        @case('shield')
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-shield text-white"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3a12 12 0 0 0 8.5 3a12 12 0 0 1 -8.5 15a12 12 0 0 1 -8.5 -15a12 12 0 0 0 8.5 -3" /></svg>
                                        @break
                                        @case('heart')
                                            <x-heroicon-o-heart class="h-8 w-8 text-white" />
                                        @break
                                        @case('leaf')
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-leaf text-white"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 21c.5 -4.5 2.5 -8 7 -10" /><path d="M9 18c6.218 0 10.5 -3.288 11 -12v-2h-4.014c-9 0 -11.986 4 -12 9c0 1 0 3 2 5h3z" /></svg>
                                        @break
                                        @case('truck')
                                         <x-heroicon-o-truck class="h-8 w-8 text-white" />
                                        @break
                                    @endswitch
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-4">{{ $value['title'] }}</h3>
                                <p class="text-gray-600 leading-relaxed">{{ $value['description'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Team --}}
            <div class="mb-20">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Đội ngũ lãnh đạo</h2>
                    <p class="text-xl text-gray-600">Những con người tài năng đứng sau thành công của Fresh Fruits</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach ($team as $member)
                        <div class="text-center group">
                            <div class="bg-white p-6 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300">
                                <div class="relative mb-6">
                                    <img src="{{ $member['image'] }}" alt="{{ $member['name'] }}" class="w-24 h-24 rounded-full object-cover mx-auto border-4 border-orange-100 group-hover:border-orange-300 transition-colors duration-300" />
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $member['name'] }}</h3>
                                <p class="text-orange-600 font-medium mb-3">{{ $member['position'] }}</p>
                                <p class="text-gray-600 text-sm">{{ $member['description'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Contact --}}
            <div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-3xl p-8 lg:p-12 text-white">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                    <div>
                        <h2 class="text-3xl font-bold mb-6">Liên hệ với chúng tôi</h2>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <span>123 Đường ABC, Quận 1, TP. Hồ Chí Minh</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span>0123 456 789</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span>info@freshfruits.vn</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span>Thứ 2 - Chủ nhật: 6:00 - 22:00</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-center lg:text-right">
                        <h3 class="text-2xl font-semibold mb-4">Bắt đầu mua sắm ngay hôm nay!</h3>
                        <p class="mb-6 opacity-90">Khám phá bộ sưu tập trái cây tươi ngon của chúng tôi</p>
                        <a href="{{ route('products.index') }}" class="bg-white text-orange-600 px-8 py-4 rounded-2xl font-semibold hover:bg-orange-50 transition-all duration-300 inline-flex items-center space-x-2">
                            <span>Xem sản phẩm</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
